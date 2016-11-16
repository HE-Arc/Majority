<?php

use Illuminate\Database\Seeder;

class QuestionAnswerTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$recordedQuestion = [
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
		
		for($i = 0; $i < count($recordedQuestion); $i++){
			$idQ = DB::table('question')->insertGetId([
				'question' => $recordedQuestion[$i][0]
			]);
			print($idQ);
			for($j = 0; $j < count($recordedQuestion[$i][1]); $j++){
				DB::table('answer')->insert([
				'answer' => $recordedQuestion[$i][1][$j],
				'question_id' => $idQ
			]);
			}
		}
    }
}
