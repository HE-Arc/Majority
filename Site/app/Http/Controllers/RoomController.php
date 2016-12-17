<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Game;
use App\Participant;
use App\Round;

class RoomController extends Controller
{
    public function show()
    {
        $participants = Participant::where('user_id', 1)->get();
        $rounds0 = Round::select("game_id")->where('n_round', 0)->get();
        $rounds1 = Round::select("game_id")->where('n_round', 1)->get();

        $gameId = [];

        foreach($rounds0 as $existedGame) {
            $found = 0;
            foreach($rounds1 as $startedGame){
                if($existedGame->game_id == $startedGame->game_id){
                    $found = 1;
                }
            }
            if($found == 0){
                array_push($gameId, $existedGame->game_id);
            }
        }
        foreach($participants as $participant) {
            if(!in_array($participant->game_id, $gameId)) {
                array_push($gameId, $participant->game_id);
            }
        }

        $games = Game::whereIn('id', $gameId)->get();

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
