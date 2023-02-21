<?php

namespace App\Http\Controllers;

use App\Helpers\HasEnsure;
use App\Models\Comment;
use App\Models\Game;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Helpers\Convert;

class GameController extends Controller
{
    use HasEnsure;
    use Convert;

    public function index(): View
    {
        $games = Game::all();
        return view('library.index')->with('games', $games->where('accepted', '==', '1')->sortBy('title'))->with('title', 'Library');
    }

    public function create(): View
    {
        return view('library.create');
    }

    public function edit(int $id): View
    {
        $game = Game::find($id);
        return view('library.edit')->with('game', $game);
    }

    public function show(int $id): View
    {
        $game = $this->ensureIsGame(Game::find($id));
        $comments = Comment::all();
        $ratings = Rating::all();
        $ratings = $ratings->where('game_id', '-', $id);
        return view('library.show')->with('comments', $comments->where('game_id', '=', $id))->with('ratings', $ratings)->with('game', $game)->with('title', $game->title);
    }

    public function update(Request $request, int $id): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        GameController::validation($request);
        $game = $this->ensureIsGame(Game::find($id));
        GameController::updateAndSave($request, $game);
        $allgames = Game::all();
        $message = "Game was updated";
        return view('library.index')->with('games', $allgames->where('accepted', '==', '1')->sortBy('title'))->with("message", $message);
    }

    private function validation(Request $request): void
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => ['required', ':games,title,NULL,NULL,year,' . $request->year],
            'category' => 'required',
            'description' => 'required',
            'year' => 'required|digits:4',
            'time' => 'required|digits_between:2,3',
            'players' => 'required'
        ]);
    }

    private function imageValidation(Request $request, Game $game): void
    {
        if ($request->hasFile('image')) {
            $image= $request->file('image');
            if ($image instanceof UploadedFile) {
                $filename = $request->title . $request->year . '.' . $image->getClientOriginalExtension();
                $image->storeAs('/public/images', $filename);
                $game->image= $filename;
                $game->save();
            }
        };
    }

    private function updateAndSave(Request $request, Game $game): void
    {
        if (strlen($this->ensureIsString($request->players)) == 1) {
            $players = $request->players.'-'.$request->players;
        } else {
            $players = $request->players;
        }
        $game->title = $this->ensureIsString($request->title);
        $game->category = $this->ensureIsString($request->category);
        $game->description = $this->ensureIsString($request->description);
        $game->year = $this->convertIfString($request->year);
        $game->time = $this->convertIfString($request->time);
        $game->players = $this->ensureIsString($players);

        GameController::imageValidation($request, $game);
        $game->save();
    }


    public function store(Request $request): View
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => ['required', 'unique:games,title,NULL,NULL,year,'.$request->year],
            'category' => 'required',
            'description' => 'required',
            'year' => 'required|digits:4',
            'time' => 'required|digits_between:2,3',
            'players' => 'required'
        ]);
        if (strlen($this->ensureIsString($request->players)) > 1) {
            $players = $request->players;
        } else {
            $players = $request->players.'-'.$request->players;
        }
        $game = Game::create([
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
            'year' => $request->year,
            'time' => $request->time,
            'players' => $players
        ]);
        $game = $this->ensureIsGame($game);
        $message = "Wait for admin to accept the game!";
        $admin = $this->ensureIsNotNullUser(Auth::user())->admin;
        if ($admin) {
            $message = "Game added!";
            $game->accepted = 1;
        }
        GameController::imageValidation($request, $game);
        $game->save();
        $games = Game::all();
        return view('library.index')->with("message", $message)->with('games', $games->where('accepted', '==', '1')->sortBy('title'));
    }

    public function deleteFromGames(int $id): RedirectResponse
    {
        $game=$this->ensureIsGame(Game::find($id));
        $game->users()->detach(Auth::id());
        return redirect()->back();
    }
    public function add(int $id): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $comments = Comment::all();
        $ratings = Rating::all();
        $user = $this->ensureIsNotNullUser(Auth::user());
        $game = $this->ensureIsGame(Game::find($id));
        $id = $this->ensureIsInteger(Auth::id());
        if (!$game->users->contains($id)) {
            $game->users()->save($user);
        }
        return view('library.show')->with('comments', $comments->where('game_id', '=', $id))->with('ratings', $ratings->where('game_id', '-', $id))->with('game', $game)->with('title', $game->title)->with('message', 'Added to your games.');
    }

    public static function numberOfGamers(int $game_id): int
    {
        return DB::table('game_user')->where('game_id', '=', $game_id)->count();
    }

    public function search(Request $request): View
    {
        if ($request->search) {
            $searchGames = Game::where('title', 'like', '%'.$request->search.'%')->where('accepted', '=', 1)->orderBy('title')->get();
            if ($searchGames->count()>0) {
                return view('library.index')->with('games', $searchGames)->with('title', 'Search results');
            } else {
                return view('library.index')->with('games', $searchGames)->with('title', 'Search results')->with('message', 'Empty search');
            }
        } else {
            $games = Game::all();
            return view('library.index')->with('title', 'Library')->with('games', $games->where('accepted', '==', '1')->sortBy('title'));
        }
    }

    public function filterGames(Request $request): View
    {
        $games = Game::where('accepted', '=', '1');
        if ($request->title_filter) {
            $games->where('title', 'like', '%' . $request->title_filter . '%');
        }
        if ($request->category_filter) {
            $games->where('category', '=', $request->category_filter);
        }
        if ($request->time_filter) {
            if ($request->time_filter == '180+') {
                $games->where('time', '>=', '180');
            } else {
                $times = explode('-', $this->ensureIsString($request->time_filter));
                $games->where('time', '>=', $times[0])->where('time', '<=', $times[1]);
            }
        }
        if ($request->players_filter) {
            $games->whereRaw("SUBSTR(players, 1, LOCATE('-', players)-1) <= " . $request->players_filter)->whereRaw("SUBSTR(players, LOCATE('-', players)+1, LENGTH(players)) >= " . $request->players_filter);
        }

        $games->orderBy('title');

        if ($games->count()>0) {
            return view('library.index')->with('games', $games->get())->with('title', 'Filter results');
        } else {
            return view('library.index')->with('games', $games)->with('title', 'Filter results')->with('message', 'No matching results');
        }
    }
    public function destroy(int $id): View
    {
        $game = $this->ensureIsGame(Game::find($id));
        if ($game != null) {
            $game->delete();
        }
        $games = Game::all();
        $message = "Game was deleted!";
        return view('library.index')->with('games', $games->where('accepted', '==', '1')->sortBy('title'))->with('title', 'Library')->with('message', $message);
    }
}
