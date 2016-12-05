<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Question;
use App\Game;

/**
 * crée plusieurs éléments dans la table game et insère des éléments dans la table participant
 * qui utilise l'id de la game ainsi que des id de user existants. Chaque élément dans game
 * aura également un champ round correspondant lié à une question déjà existante
 */
class GamesParticipantsRoundsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $questions = Question::all();

        if(count($users) >= 2) {
            for($i = 0; $i < 5; $i++) {
                $max_duration = 5;
                $max_player = 12;
                $description = "salle N°$i";
                $n_round = 0;
                $owner = $users->random();

                $game = $owner->games()->create(compact('max_duration', 'max_player', 'description'));

                $participants = $users->random(5)->all();

                $state = 0;
                foreach($participants as $participant) {
            	       $participant->participations()->attach($game, compact('state'));
                }
                $question_id = $questions->random()->id;
                $game->rounds()->create(compact('question_id', 'n_round'));
            }
        }
    }
}
