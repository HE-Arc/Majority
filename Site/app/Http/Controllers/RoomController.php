<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Game;

class RoomController extends Controller
{
    public function show()
    {
		$games = Game::all();
				
        return view('rooms')->withGames($games);
    }
}
