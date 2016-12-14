<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Chosen_answer;
use App\User;
use App\Question;
use App\Participant;
use App\Game;
use App\Round;
use App\Answer;

class GameController extends Controller
{
    public function show()
    {
        if($_POST["typeRequest"] == "create"){
            $questions = Question::all();

            $max_duration = $_POST["duration"];
            $max_player = $_POST["nbPlayer"];
            $description = $_POST["name"];
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
                $user = User::where('id', $_POST["idUser"])->first();

                $user->participations()->attach($game, compact('state'));
            }
        }else if($_POST["typeRequest"] == "answer"){
            $participant = Participant::where('user_id', $_POST["idUser"])->where('game_id', $_POST["gameId"])->first();
            $game = Game::where('id', $_POST["gameId"])->first();
        }

        $rounds =Round::where('game_id', $game->id)->get();
        $lastId = $rounds->max('n_round');
        $lastRound = $rounds->where('n_round', $lastId)->first();

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

        foreach($participants as $participant) {
            $answer = Chosen_answer::where('user_id', $participant->user_id)
                                    ->where('n_round', 0)
                                    ->where('game_id', $game->id)->first();
            if($answer != null){
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
        "gameId" => $game->id];

        return view('game')->withData($data);
    }
}
