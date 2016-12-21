<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\ChosenAnswer;
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

        // FIXME: WTF! --Yoan
		if($_POST["typeRequest"] == "refresh"){
            $game_id  = $_POST["gameId"];
            $game = Game::where('id', $game_id)->first();
			$user = User::where('id', $_POST["idUser"])->first();
        }
        if($_POST["typeRequest"] == "create"){
            $questions = Question::all();

            $n_round = 0;
            $max_duration = $_POST["duration"];
            $max_player = $_POST["nbPlayer"];
            $description = $_POST["name"];
            $owner = User::where('id', $_POST["idUser"])->first();

            $game = $owner->games()->create(compact('max_duration', 'max_player', 'description'));


            $state = 1;
            $owner->participations()->attach($game, compact('state'));

            $question_id = $questions->random()->id;
            $game->rounds()->create(compact('question_id', 'n_round'));
        }else if($_POST["typeRequest"] == "join"){
            $participant = Participant::where('user_id', $_POST["idUser"])->where('game_id', $_POST["gameId"])->first();

            $game = Game::where('id', $_POST["gameId"])->first();
            if($participant == null){
                $questions = Question::all();
                $state = 1;
                $user = User::where('id', $_POST["idUser"])->first();

                $user->participations()->attach($game, compact('state'));
            }
        }else if($_POST["typeRequest"] == "answer"){
            $participant = Participant::where('user_id', $_POST["idUser"])->where('game_id', $_POST["gameId"])->first();
            $game = Game::where('id', $_POST["gameId"])->first();
        }

		$timeout = false;
		if($_POST["typeRequest"] == "timeout") {
			$timeout = true;

			$game_id = $_POST["gameId"];
			$game = Game::where('id', $game_id)->first();
			$rounds =Round::where('game_id', $game->id)->get();
			$n_round = $rounds->max('n_round');
		}
		$fin = "";
		//$game = Game::where('id', $_POST["gameId"])->first();
        $rounds =Round::where('game_id', $game->id)->get();
        $lastId = $rounds->max('n_round');
        $lastRound = $rounds->where('n_round', $lastId)->first();

		$dateFrom = new DateTime($lastRound->created_at);
		$dateNow = new DateTime();

		$interval = $dateNow->diff($dateFrom);
		$secondesTotales = $game->max_duration *60;

		$mi = $interval->format('%i');
		$si = $interval->format('%s');
		$secondesEcoules = $mi * 60 + $si;

		$remain = $secondesTotales - $secondesEcoules;

		if($remain <= 0 || $timeout)
		{
			$timeout = false;
			$game_id = $game->id;
			$game = Game::where('id', $game_id)->first();
			if($game != null){
				$rounds = Round::where('game_id', $game->id)->get(); //récupère la liste des rounds popur une game défini
				$n_round = $rounds->max('n_round');

				$answers = ChosenAnswer::where('game_id', $game_id)
										  ->where('n_round', $n_round)->get();

				$counter = ChosenAnswer::select(\DB::raw('count(user_id) as user_count, game_id, n_round, answer_id'))
										   ->where('game_id', $game_id)
										   ->where('n_round', $n_round)
										   ->groupBy(['game_id', 'n_round', 'answer_id'])
										   ->orderBy('user_count', 'desc')->get();
				$participants = Participant::where('game_id',$game_id)->get();
				if(isset($counter[0])){
						$max = $counter[0]->user_count;
						$answerIdMax = [];
						foreach($counter as $count){
							if($count->user_count < $max){
								break;
							}
							array_push($answerIdMax, $count->answer_id);
						}
						$survivor = [];
						foreach($answers as $answer){
							if(!in_array($answer->answer_id, $answerIdMax)) {
								Participant::where('user_id', $answer->user_id)
											->where('game_id', $answer->game_id)
											->update(['state' => 0]);
							} else {
								array_push($survivor, $answer->user_id);
							}
						}
						foreach($participants as $participant){
							$response = false;
							foreach($answers as $ans){
								if($ans->user_id ==$participant->user_id)
								{
									$response=true;
								}
							}
							if ($response == false) {
							   Participant::where('user_id', $participant->user_id)
											->where('game_id', $game_id)
											->update(['state' => 0]);
								$response=false;
							}

						}
					if(count($survivor) == 2){
						Participant::where('user_id', $survivor[0])
									 ->orwhere('user_id', $survivor[1])
									 ->where('game_id', $game_id)
									 ->update(['state' => 2]);
						$fin= "Partie terminée";
						$remaining = "Partie terminée";
					}
					else{
						if(count($survivor) < 2){
							$remaining = "Partie terminée";
							$fin= "Partie terminée";
						}
						else{
							$n_round  += 1;
							$question = Question::inRandomOrder()->first();
							$question_id = $question->id;
							$game->rounds()->create(compact('n_round', 'question_id'));
						}
					}
				}

			}
			//$_POST["typeRequest"] = "join";
            $rounds =Round::where('game_id', $game->id)->get();
            $lastId = $rounds->max('n_round');
            $lastRound = $rounds->where('n_round', $lastId)->first();

    		$remain = $secondesTotales;
		}
		$remaining = "Secondes restantes avant le prochain round: ".$remain;

        if($_POST["typeRequest"] == "answer"){
            if($participant->state == 1) {
                $game_id = $game->id;
                $n_round = $_POST["nRound"];
                $answer_id = $_POST["idAnswer"];
                $user_id = $participant->user_id;
                $answer = Answer::where('id', $_POST["idAnswer"])->first();
                if($answer != null) {
                    $answerExist = ChosenAnswer::where('n_round', $n_round)->where('game_id', $game_id)->where('user_id', $user_id)->first();
                    if($answerExist == null){
                        $answer->ChosenAnswers()->create(compact('n_round', 'game_id', 'user_id'));
                    }
                }
            }
        }

        $question = Question::where('id', $lastRound->question_id)->first();
        $questionAnswers = Answer::where('question_id', $question->id)->get();

        //Player: nom => [etat (en jeu/éliminé), réponse à la question actuelle]
        $participants = Participant::where('game_id', $game->id)->get();
        $listPlayers = [];
        $logedParticipant = Participant::where('user_id', Auth::id())->where('game_id', $game->id)->first();
        $logedParticipantAnswer = ChosenAnswer::where('user_id', $logedParticipant->user_id)
                                ->where('n_round', $lastRound->n_round)
                                ->where('game_id', $game->id)->first();


        foreach($participants as $participant) {
            $answer = ChosenAnswer::where('user_id', $participant->user_id)
                                    ->where('n_round', $lastRound->n_round)
                                    ->where('game_id', $game->id)->first();
            if($answer != null && ($logedParticipantAnswer != null || $logedParticipant->state != 1)){
                foreach($questionAnswers as $key => $QA){
                    if($QA->id == $answer->answer_id){
                        $answer = $key+1;
                        break;
                    }
                }
            } else {
                $answer = 0;
            }
            $name = User::where('id', $participant->user_id)->first()->name;
            $state = $participant->state;
            $listPlayers[$name] = [$state, $answer];
        }


        $data = ["players" => $listPlayers,
        "question" => $question->question,
        "answers" => $questionAnswers,
        "gameStarted" => true,
        "gameId" => $game->id,
        "remainingTime" => $remaining,
        "owner" => $game->owner_id,
        "nRound" => $lastRound->n_round,
		"finPartie" => $fin];


       return view('game')->withData($data);
    }

}
