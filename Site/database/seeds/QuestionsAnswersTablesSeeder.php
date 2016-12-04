<?php

use Illuminate\Database\Seeder;

use App\Question;

/**
 * Remplit la table question avec des questions lisibles, chacune de ces questions
 * aura au moins 4 réponses lisibles, inserées et associées à la bonne question dans la table answer
 */
class QuestionsAnswersTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$recordedQuestions = [
		['Qui aiment les carottes',
						['Moi',
						'Pas moi',
						'Lui',
						"L'autre"]],
		['La réponse du calcul 1+1',
						['1',
						'11',
						'plus',
						'pas assez',
						'1914',
						'Jules Cesar']],
		["Que pensez-vous de ce texte \":)\"",
						['Introspection',
						"c'est beau",
						"Ceci n'est pas une pipe",
						"Pluôt deux fois qu'une"]]];
						
		foreach($recordedQuestions as $val) {
			list($question, $answers) = $val;
			$q = Question::create(compact('question'));
			
			foreach($answers as $answer) {
				$q->answers()->create(compact('answer'));
			}
			
		}
    }
}
