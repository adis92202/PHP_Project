<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use App\Helpers\HasEnsure;

class AuctionController extends Controller
{
    use HasEnsure;

    public function index(): View
    {
        return view('auctions.index')->with('auctions', Auction::where('accepted', '=', '1')->get())->with('title', 'Market');
    }

    public function create(): View
    {
        return view('auctions.create');
    }

    public function edit(int $id): View
    {
        $auction = Auction::find($id);
        return view('auctions.edit')->with('auction', $auction);
    }

    private function updateAndSave(Auction $auction, Request $request): void
    {
        $auction->title = $this->ensureIsString($request->game_title);
        $auction->state = $this->ensureIsString($request->state);
        $auction->description = $this->ensureIsString($request->description);
        if (gettype($request->price) == 'double' or gettype($request->price) == 'integer') {
            $auction->price = $request->price;
        } elseif (gettype($request->price) == 'string') {
            $auction->price = (float)$request->price;
        }
        //$auction->price = $request->price;
        $auction->email  = $this->ensureIsString($request->email);
        $auction->phone = $this->ensureIsString($request->phone);
        $id = Auth::id();
        if (gettype($id) != 'integer') {
            abort(500, 'Not logged in!');
        }
        $auction->user_id = $id;
        $auction->save();
    }

    public function store(Request $request): View
    {
        AuctionController::validation($request);
        $auction = new Auction();
        $message = "Wait for admin to accept your auction!";
        $admin = $this->ensureIsNotNullUser(Auth::user())->admin;
        if ($admin) {
            $message = "Auction added!";
            $auction->accepted = 1;
        }
        $this->updateAndSave($auction, $request);
        $auctions = Auction::all();
        return view('auctions.index')->with('auctions', $auctions->where('accepted', '=', '1'))->with("message", $message);
    }

    private function validation(Request $request): void
    {
        $request->validate([
            'game_title' => 'required',
            'state' => 'required',
            'price' => 'required',
            'description' => 'required',
            'email' => 'required|email',
            'phone' => 'required|digits:9'
        ]);
    }

    public function update(Request $request, int $id): View
    {
        AuctionController::validation($request);
        $auction = Auction::find($id);
        if ($auction != null) {
            $this->updateAndSave($auction, $request);
        }
        //return Redirect::route('profile.auctions')->with('message', 'Your auction was updated.');
        $message = 'Your auction was updated!';
        //if (str_contains(url()->previous(), "profile")) {
        $auctions = Auction::where('user_id', '=', Auth::id())->get();
        return view('profile.auctions')->with('auctions', $auctions)->with('title', 'Your Auctions')->with('message', $message);
        //}
        //return view('auctions.index')->with('auctions', Auction::where('accepted', '=', '1')->get())->with('title', 'Market')->with('message', $message);
    }

    public function destroy(int $id): View
    {
        $auction = Auction::find($id);
        if ($auction != null) {
            $auction->delete();
        }
        $message = 'Your auction was deleted!';

        if (str_contains(url()->previous(), "profile")) {
            $auctions = Auction::where('user_id', '=', Auth::id())->get();
            return view('profile.auctions')->with('message', $message)->with('title', 'Your Auctions')->with('auctions', $auctions);
        }
        return view('auctions.index')->with('auctions', Auction::where('accepted', '=', '1')->get())->with('title', 'Market')->with('message', $message);
    }

    public function filterAuctions(Request $request): View
    {
        $auctions = Auction::where('accepted', '=', '1');
        $auctions_get = $auctions->get();
        if ($auctions_get->isEmpty()) {
            return view('auctions.index')->with('auctions', Auction::all())->with('title', 'Filter results');
        }
        if ($request->title_filter) {
            $auctions->where('title', 'like', '%' . $request->title_filter . '%');
        }
        if ($request->state_filter) {
            $auctions->where('state', '=', $request->state_filter);
        }
        if ($request->price_filter) {
            if ($request->price_filter == '200+') {
                $auctions->where('price', '>=', '200');
            } else {
                $prices = explode('-', $this->ensureIsString($request->price_filter));
                $auctions->where('price', '>=', $prices[0])->where('price', '<=', $prices[1]);
            }
        }

        $auctions->orderBy('title');

        if ($auctions->count()>0) {
            return view('auctions.index')->with('auctions', $auctions->get())->with('title', 'Filter results');
        } else {
            return view('auctions.index')->with('auctions', $auctions->get())->with('title', 'Filter results')->with('message', 'No matching results');
        }
    }
}
