<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;

use App\Game;
use App\Participant;
use App\Round;
use App\User;

class RoomController extends Controller
{
    public function show()
    {
        $games = Game::all();
		$rounds1 = Round::where('n_round', 1)->get();
		
		$user = User::where('id', Auth::id())->first();
        $data = [];

        foreach($games as $game) {
			$addRoom = false;
            $participants = Participant::where('game_id', $game->id)->get();

			if($game->max_player > count($participants)){
				$addRoom = true;
				foreach($rounds1 as $startedGame){
					if($game->id == $startedGame->game_id){
						$addRoom = false;
						break;
					}
				}
			}
			
			foreach($participants as $participant) {
				if($participant->user_id == $user->id) {
					$addRoom = true;
					break;
				}
			}
			
			if($addRoom){
				array_push($data, [$game, count($participants)]);
			}
        }

        return view('rooms')->withData($data);
    }
}
