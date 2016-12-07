<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Round;
use App\Game;
use DateTime;

class GameController extends Controller
{
    public function show()
    {
		
		$games = Game::all();
        //print($games);
        foreach($games as $game) {
            $rounds = Round::where('game_id', $game->id)->get(); //récupère la liste des rounds popur une game défini
			$LastId = $rounds->max('n_round');
            $lastRound = $rounds->where('n_round', $LastId)->first();
		}
		
		$dateFrom = new DateTime($lastRound->created_at);
		$dateNow = new DateTime();

		$interval = $dateNow->diff($dateFrom);
		
		$totalTime = new DateTime('00:05:00');
		$secondesTotales = $totalTime->format('%i');
		
		$mi = $interval->format('%i');
		$si = $interval->format('%s');
		$secondesEcoules = $mi * 60 + $si;

		$result = $secondesTotales - $secondesEcoules;
		
		//Player: nom => [etat (en jeu/éliminé), réponse à la question actuelle]
       $data = ["players" => [
					"Julien" => [1,0],
					"Vincent" => [1,2],
					"Joel" => [0,0]
					],
				"question" => "Qui a découvert l'Amérique?",
				"answers" => ["42", "Obiwan Kenobi", "Bleu", "Une girafe"],
				"gameStarted" => true,
				"remainingTime" => $result];

       return view('game')->withData($data);
    }
}
