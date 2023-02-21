<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Game;
use Illuminate\View\View;
use App\Helpers\HasEnsure;
use App\Helpers\Convert;

class RatingController extends Controller
{
    use HasEnsure;
    use Convert;

    public function store(Request $request): View
    {
        $request->validate([
            'rating' => 'required'
        ]);

        $id = $this->ensureIsInteger(Auth::id());
        //$rating = Rating::where('user_id', $id)->where('game_id', '==', $request->game_id);
        $game_id = $request->game_id;

        $rating = Rating::where(function ($query) use ($id) {
            $query->where('user_id', '=', $id);
        })->where(function ($query) use ($game_id) {
            $query->where('game_id', '=', $game_id);
        })->get();

        if ($rating->count() == 0 or $rating == null) {
            $rating = new Rating();
        } else {
            $rating = $rating->first();
            if ($rating == null) {
                abort(500, 'Rating not in database');
            }
        }

        $rating->user_id = $id;
        $rating->rating = $this->convertIfString($request->rating);
        $rating->game_id = $this->convertIfString($request->game_id);
        $rating->save();
        $game = $this->ensureIsGame(Game::find($request->game_id));

        $game_id = $game->id;

        $comments = Comment::where(function ($query) use ($game_id) {
            $query->where('game_id', '=', $game_id);
        })->get();

        $ratings = Rating::where(function ($query) use ($game_id) {
            $query->where('game_id', '=', $game_id);
        })->get();

        //return view('library.show')->with('game', $game)->with('comments', Comment::all()->where('game_id', '==', $game->id))->with('ratings', Rating::all()->where('game_id', '==', $game->id))->with("message", "Your rating was added")->with('title', $game->title);
        return view('library.show')->with('game', $game)->with('comments', $comments)->with('ratings', $ratings)->with("message", "Your rating was added")->with('title', $game->title);
    }

    public static function avg_rating(int $game_id): float|string
    {
        $sum = 0;
        $ratings = Rating::where(function ($query) use ($game_id) {
            $query->where('game_id', '=', $game_id);
        })->get();

        if ($ratings->count() == 0) {
            return "N/A";
        }

        foreach ($ratings as $rating) {
            $sum += $rating->rating;
        }
        return round($sum/$ratings->count(), 2);
    }

    public static function numberOfRatings(int $game_id): int
    {
        $ratings = Rating::where(function ($query) use ($game_id) {
            $query->where('game_id', '=', $game_id);
        })->get();
        return $ratings->count();
    }
}
