<?php

namespace App\Http\Controllers;

use App\Helpers\HasEnsure;
use App\Models\Event;
use App\Models\Game;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    use HasEnsure;

    public function welcome(): View
    {
        $min_event = DB::table('events')->where('accepted', '=', '1')->orderBy('date')->orderBy('time')->first();
        $latest4 = DB::table('games')->where('accepted', '=', '1')->orderBy('created_at', 'DESC')->limit(4)->get();

        return view('welcome')->with('event', $min_event ?? '')->with('games', $latest4);
    }
}
