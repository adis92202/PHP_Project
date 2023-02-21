<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Game;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Helpers\HasEnsure;
use App\Helpers\Convert;

class CommentController extends Controller
{
    use HasEnsure;
    use Convert;

    private function updateAndSave(Comment $comment, Request $request): void
    {
        $comment->text = $this->ensureIsString($request->description);
        $id = $this->ensureIsInteger(Auth::id());
        $comment->user_id = $id;
        $game_id = $this->convertIfString($request->game_id);
        $comment->game_id = $game_id;
        $check = Comment::all();
        $check = $check->where('user_id', '=', $id)->where('game_id', '=', $request->game_id)->where('text', '=', $request->description);
        if ($check->count()<1) {
            $comment->save();
        }
    }

    public function store(Request $request): View
    {
        $request->validate([
            'description' => 'required'
        ]);

        $comment = new Comment();
        $this->updateAndSave($comment, $request);
        $game = $this->ensureIsGame(Game::find($request->game_id));
        $comments = Comment::all();
        $ratings = Rating::all();
        return view('library.show')->with('game', $game)->with('comments', $comments->where('game_id', '==', $game->id))->with('ratings', $ratings->where('game_id', '==', $game->id))->with("message", "Your comment was added.")->with('title', $game->title);
    }

    public function update(Request $request, Comment $comment): \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
    {
        $request->validate([
            'description' => 'required'
        ]);
        if ($comment == null) {
            abort(500, 'Cannot update the comment');
        }
        $this->updateAndSave($comment, $request);
        return redirect()->back();
    }

    public function destroy(Comment $comment): View
    {
        if ($comment != null) {
            $comment->delete();
        }
        return view('library.index')->with('games', Game::all());
    }
}
