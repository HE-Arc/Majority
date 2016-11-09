<?php

use Illuminate\Database\Seeder;

class QuestionAnswerTablesSeeeder extends Seeder
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
						"L\'autre"]],
		['La réponse du calcul 1+1',
						['1',
						'11',
						'plus',
						'pas assez',
						'1914'
						'Jules Cesar']]];
		
		for($i = 0; $i < count($recordedQuestion]; $i++){
			$question = DB::table('question')->insert([
				'question' => $recordedQuestion[$i][0]
			]);
			
			for($j = 0; $j < count($recordedQuestion[$i][1]); $j++){
				DB::table('answer')->insert([
				'answer' => $recordedQuestion[$i][1][$j],
				'question_id' => $question->$id
			]);
			}
		}
    }
}
