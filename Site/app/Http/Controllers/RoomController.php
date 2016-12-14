<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Game;
use App\Participant;

class RoomController extends Controller
{
    public function show()
    {
		$games = Game::all();

    $data = [];

    foreach($games as $game) {
      $participants = Participant::where('game_id', $game->id)->get();

      $i = 0;
    //  if($game->max_player > count($participants)){
      //  $data[$i] = [$game, count($participants)];
        $i++;
        array_push($data, [$game, count($participants)]);
    //  }
    }

           return view('rooms')->withData($data);
    }
}
