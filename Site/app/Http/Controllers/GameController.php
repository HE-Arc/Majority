<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Question;
use App\Participant;
use App\Game;
use App\Round;
use App\Answer;
use DateTime;

class GameController extends Controller
{
    public function show()
    {
		
		$games = Game::all();

        foreach($games as $game) {
            $rounds = Round::where('game_id', $game->id)->get(); //récupère la liste des rounds popur une game défini
			$LastId = $rounds->max('n_round');
            $lastRound = $rounds->where('n_round', $LastId)->first();
		}
		
		$dateFrom = new DateTime($lastRound->created_at);
		$dateNow = new DateTime();

		$interval = $dateNow->diff($dateFrom);
		
		$totalTime = new DateTime('00:05:00');
		$secondesTotales = $game->max_duration;
		
		$mi = $interval->format('%i');
		$si = $interval->format('%s');
		$secondesEcoules = $mi * 60 + $si;

		$remain = $secondesTotales - $secondesEcoules;
		
		if($remain <= 0)
		{
			//Créer nouveau round
		}
		

				
			if($_POST["typeRequest"] == "create"){
				$questions = Question::all();
				
				$max_duration = $_POST["duration"];
                $max_player = $_POST["nbPlayer"];
                $description = $_POST["name"];
                $n_round = 0;
                $owner = User::where('id', $_POST["idUser"])->first();
				
				$game = $owner->games()->create(compact('max_duration', 'max_player', 'description'));


                $state = 0;
            	$owner->participations()->attach($game, compact('state'));
                
                $question_id = $questions->random()->id;
                $game->rounds()->create(compact('question_id', 'n_round'));
			}else if($_POST["typeRequest"] == "join"){
				$participant = Participant::where('user_id', $_POST["idUser"])->where('game_id', $_POST["gameId"])->first();
				
				$game = Game::where('id', $_POST["gameId"])->first();
				if($participant == null){
					$questions = Question::all();
					$state = 0;
					$n_round = 0;
					$user = User::where('id', $_POST["idUser"])->first();
					
					$user->participations()->attach($game, compact('state'));
				}
			}
			
			//Player: nom => [etat (en jeu/éliminé), réponse à la question actuelle]
			$participants = Participant::where('game_id', $game->id)->get();
			$listPlayers = [];
			
			foreach($participants as $participant) {
				
			}
			
			$rounds =Round::where('game_id', $game->id)->get();
			$lastId = $rounds->max('n_round');
			$lastRound = $rounds->where('n_round', $lastId)->first();
			
			$question = Question::where('id', $lastRound->question_id)->first();
			$questionAnswers = Answer::where('question_id', $question->id)->get();
				$data = ["players" => [
 					"Julien" => [1,0],
 					"Vincent" => [1,2],
 					"Joel" => [0,0]
 					],
				"question" => $question->question,
				"answers" => $questionAnswers,
				"gameStarted" => true,
				"remainingTime" => $remain];
				
       return view('game')->withData($data);
    }
}
