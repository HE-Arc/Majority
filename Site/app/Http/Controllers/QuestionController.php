<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class QuestionController extends Controller
{
    public function method(Request $request)
	{
		$question = $request->question;
		event(new EventMasterEmitNewQuestion($question));
	}
}
