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
class ChosenAnswersTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $games = Game::all();

        foreach($games as $game) {
            // FIXME: Utilisez l'ORM. -Yoan
            //$rounds = Round::where('game_id', $game->id)->get(); //récupère la liste des rounds popur une game défini
            $rounds = $game->rounds()->get();
            // Ceci n'est plus du SQL, mais collections. -Yoan
            $LastId = $rounds->max('n_round');
            $lastRound = $rounds->where('n_round', $LastId)->first();
            // FIXME: idem
            //$participants = Participant::where('game_id',$game->id)->get();
            $participants = $game->participants()->get();

            foreach($participants as $participant) {
                $answer = Answer::where('question_id', $lastRound->question_id)->inRandomOrder()->first(); //récupère une réponse aléatoire pour une question défini

                //ajoute la réponse
                $chosen_answer = $answer->chosenAnswers()->create(
                    ['n_round' => $lastRound->n_round,
                     'game_id' => $lastRound->game_id,
                     'user_id' => $participant->user_id]);
            }
        }

    }
}
