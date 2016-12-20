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
                        'pas assez']],
        ['Qui est notre seigneur et maitre',
                        ['Adolf Hitler',
                        'Yoan Blanc',
                        'Donald Trump',
                        'WebJoel']],
        ['Qui est le premier alien humain',
                        ['Le Docteur',
                        "L'IMPERIUM",
                        'Zorro',
                        'La Reine des lames']],
        ["De qui est la phrase \"Je vous ai compris\"",
                        ['Walter White',
                        "Kim Jung Un",
                        'Théo de Silverberg',
                        'Atilla']],
        ["Qui gagnerait entre les personnages suivants",
                        ['Chuck Norris',
                        "Bruce Lee",
                        'Batman',
                        'My Name is Bond']],
        ["Que pensez-vous du hasard",
                        ['Oui',
                        "Oui",
                        'Oui',
                        'Oui']],
        ["Que pensez-vous de ce texte \":)\"",
                        ['Introspection',
                        "c'est beau",
                        "Trop long",
                        ":)"]]];

        foreach($recordedQuestions as $val) {
            list($question, $answers) = $val;
            $q = Question::create(compact('question'));

            foreach($answers as $answer) {
                $q->answers()->create(compact('answer'));
            }

        }
    }
}
