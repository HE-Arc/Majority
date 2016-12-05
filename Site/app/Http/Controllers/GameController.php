<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class GameController extends Controller
{
    public function show()
    {
		//Player: nom => [etat (en jeu/éliminé), réponse à la question actuelle]
       $data = ["players" => [
					"Julien" => [1,0],
					"Vincent" => [1,2],
					"Joel" => [0,0]
					],
				"question" => "Qui a découvert l'Amérique?",
				"answers" => ["42", "Obiwan Kenobi", "Bleu", "Une girafe"],
				"gameStarted" => true];
					
       return view('game')->withData($data);
    }
}
