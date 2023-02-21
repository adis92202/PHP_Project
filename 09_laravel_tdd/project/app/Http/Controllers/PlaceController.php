<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlaceController extends Controller
{
    public function index(): View
    {
        $initialMarkers = [
            [
                'position' => [
                    'lat' => 50.06635235211256,
                    'lng' => 19.956757096253227
                ],
                'label' => [ 'color' => 'white', 'text' => 'B' ],
                'name' => 'Boardowa',
                'address' => 'Topolowa 52 <br> 31-506 Kraków',
                'draggable' => false
            ],
            [
                'position' => [
                    'lat' => 50.059455781943846,
                    'lng' => 19.948882110990954
                ],
                'label' => [ 'color' => 'white', 'text' => 'H' ],
                'name' => 'Hex Cafe',
                'address' => 'Generała Józefa Dwernickiego 5 <br> 31-530 Kraków',
                'draggable' => false
            ],
            [
                'position' => [
                    'lat' => 50.05315639171277,
                    'lng' => 19.945832505463226
                ],
                'label' => [ 'color' => 'white', 'text' => 'D' ],
                'name' => 'Domówka Cafe',
                'address' => 'Miodowa 28 a <br> 31-050 Kraków',
                'draggable' => false
            ]
        ];
        return view('places.index', compact('initialMarkers'))->with('title', 'Places to play');
    }
}
