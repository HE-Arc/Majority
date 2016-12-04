<?php

use Illuminate\Database\Seeder;
use App\Participant;
use App\Answer;
use App\Game;
use App\Round;
/**
 * pour chaque dernier round ajouter de chaque game, va inserer dans la table chosen_answer,
 * une réponse aléatoire (choisi parmi celle liée à la question du dernier round) de chaque
 * participant de la game
 */
class Chosen_AnswersTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$games = Game::all();

		//print($games);
		foreach($games as $game) {
            $rounds = Round::where('game_id', $game->id)->get(); //récupère la liste des rounds popur une game défini
            $LastId = $rounds->max('id'); //comme on ne stocke pas l'ordre des rounds dans la Game
                                          //j'ai fait cette solution-là, est-ce qu'il faudrait ajouter un champ ?
            $lastRound = $rounds->where('id', $LastId)->first();
            $participants = Participant::where('game_id',$game->id)->get();

            //debug
            //print("round: $lastRound->id question: $lastRound->question_id\n");

            foreach($participants as $participant) {
                $answer = Answer::where('question_id', $lastRound->question_id)->inRandomOrder()->first(); //récupère une réponse aléatoire pour une question défini

                //debug
                //print("{participant : $participant->user_id game: $participant->game_id }\n");
                //print("answer ($answer->id) :$answer->answer\n");

                //ajoute la réponse
                $chosen_answer = $lastRound->Chosen_answers()->create(
                    ['user_id' => $participant->user_id,
                     'answer_id' => $answer->id]);
            }
            //debug
            //print("\n");
		}
    }
}
