<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\Chosen_answer;
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
                $state = 0;
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
				
				$answers = Chosen_answer::where('game_id', $game_id)
										  ->where('n_round', $n_round);

				$counter = Chosen_answer::select(\DB::raw('count(user_id) as user_count, game_id, n_round, answer_id'))
										   ->where('game_id', $game_id)
										   ->where('n_round', $n_round)
										   ->groupBy(['game_id', 'n_round', 'answer_id'])
										   ->orderBy('user_count', 'desc')->get();
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
											->update(['state' => 1]);
							} else {
								$survivor.array_push($answer->user_id);
							}
						}
				
					if(count($survivor) == 2){
						Participant::where('user_id', $survivor[0])
									 ->orwhere('user_id', $survivor[1])
									 ->where('game_id', $game_id)
									 ->update(['state' => 2]);
					}
				}
				$n_round  += 1;
				$question = Question::inRandomOrder()->first();
				$question_id = $question->id;
				$game->rounds()->create(compact('n_round', 'question_id'));
			}
			$_POST["typeRequest"] = "join";
		}

        if($_POST["typeRequest"] == "answer"){
            $game_id = $game->id;
            $n_round = $lastRound->n_round;
            $answer_id = $_POST["idAnswer"];
            $user_id = $participant->user_id;
            //if($participant->state != 0) {
            $answer = Answer::where('id', $_POST["idAnswer"])->first();
            if($answer != null) {
                $answerExist = Chosen_answer::where('n_round', $n_round)->where('game_id', $game_id)->where('user_id', $user_id)->first();
                if($answerExist == null){
                    $answer->Chosen_answers()->create(compact('n_round', 'game_id', 'user_id'));
                }
            }
        }

        $question = Question::where('id', $lastRound->question_id)->first();
        $questionAnswers = Answer::where('question_id', $question->id)->get();

        //Player: nom => [etat (en jeu/éliminé), réponse à la question actuelle]
        $participants = Participant::where('game_id', $game->id)->get();
        $listPlayers = [];
        $logedParticipant = Participant::where('user_id', Auth::id())->where('game_id', $game->id)->first();
        $logedParticipantAnswer = Chosen_answer::where('user_id', $logedParticipant->user_id)
                                ->where('n_round', $lastRound->n_round)
                                ->where('game_id', $game->id)->first();


        foreach($participants as $participant) {
            $answer = Chosen_answer::where('user_id', $participant->user_id)
                                    ->where('n_round', $lastRound->n_round)
                                    ->where('game_id', $game->id)->first();
            if($answer != null && $logedParticipantAnswer != null){
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
        "remainingTime" => $remain,
        "owner" => $game->owner_id];


       return view('game')->withData($data);
    }

}
