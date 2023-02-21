<?php

namespace App\Http\Controllers;

use App\Helpers\HasEnsure;
use App\Helpers\Convert;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Auction;
use App\Models\Event;
use App\Models\Game;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Collection;
use App\Models\GameUser;

class ProfileController extends Controller
{
    use HasEnsure;
    use Convert;

    public function index(): View
    {
        return view('profile.index')->with('title', 'Profile');
    }
    public function games(): View
    {
        $rating = Rating::all();
        $games = $this->ensureIsUser(User::find(Auth::id()))->games->where('accepted', '=', '1');
        return view('profile.games')->with('title', 'Your Games')->with('games', $games)->with('ratings', $rating->where('user_id', '==', Auth::id()));
    }
    public function events(): View
    {
        $part_events = $this->ensureIsUser(User::find(Auth::id()))->events;
        $your_events = $this->ensureIsUser(User::find(Auth::id()))->myEvents->sortBy('event_title');
        return view('profile.events')->with('part_events', $part_events->where('accepted', '=', '1')->sortBy('title'))->with('title', 'Your Events')->with('your_events', $your_events);
    }
    public function auctions(): View
    {
//        $auctions = Auction::all()->where('user_id', '=', Auth::id());
        $auctions = Auction::where('user_id', '=', Auth::id())->get();
        //$auctions = User::find(Auth::id())->auctions;
        return view('profile.auctions')->with('title', 'Your Auctions')->with('auctions', $auctions);
    }
    public function acceptance(): View
    {
        $all = $this->load_all_unaccpted();
        return view('profile.acceptance')->with('title', 'Acceptance')->with($all);
    }
    public function settings(): View
    {
        return view('profile.settings')->with('title', 'Settings');
    }
    public function accept(string $element, int $id): \Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $data = $this->get_data($element, $id);
        $data->accepted = 1;
        $data->save();
        $all = $this->load_all_unaccpted();
        return redirect('/profile/acceptance')->with('title', 'Acceptance')->with($all);
    }
    public function get_data(string $element, int $id): Game|Event|Auction
    {
        if ($element=="Event") {
            $data = $this->ensureIsEvent(Event::find($id));
        } elseif ($element=="Game") {
            $data = $this->ensureIsGame(Game::find($id));
        } else {
            $data = $this->ensureIsAuction(Auction::find($id));
        }
        return $data;
    }
    public function decline(string $element, int $id): \Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $data = $this->get_data($element, $id);
        $data->delete();
        $all = $this->load_all_unaccpted();
        return redirect('/profile/acceptance')->with('title', 'Acceptance')->with($all);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ])->with('title', 'Profile');
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): View
    {
        $user = $this->ensureIsNotNullUser($request->user());

        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users,username,'.Auth::id()],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.Auth::id() ],
            'city' => ['nullable', 'string', 'max:255'],
            'age' => [ 'nullable', 'integer' ],
        ]);

        $data = $this->ensureIsArray($request->validated());

        $user->fill($data);
        $user->username = $this->ensureIsStringOrNull($request->username);
        $user->city = $this->ensureIsStringOrNull($request->city);
        $user->age=$this->convertString($request->age);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return view('profile.settings')->with('message', 'Profile updated')->with('title', 'Settings');
    }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current-password'],
        ]);

        $user = $this->ensureIsNotNullUser($request->user());

        $user->events()->detach();
        $user->games()->detach();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public static function your_avg_rating(): float
    {
        $ratings = hasEnsure::ensureIsNotNullUser2(User::find(Auth::id()))->ratings;
        $avg = 0;
        foreach ($ratings as $rating) {
            $avg += $rating['rating'];
        }
        return $ratings->count() ? round($avg/$ratings->count(), 2) : 0.0;
    }

    /**
     * @return array<string, Collection<int, Auction>|Collection<int, Event>|Collection<int, Game>>
     */
    public function load_all_unaccpted(): array
    {
        $games = Game::where('accepted', '=', 0)->get();
        $auctions = Auction::where('accepted', '=', 0)->get();
        $events = Event::where('accepted', '=', 0)->get();
        return ['events'=>$events, 'auctions'=>$auctions, 'games'=>$games];
    }
}
