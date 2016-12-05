<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public function Chosen_answers()
    {
        return $this->hasMany('App\Chosen_answer');
    }
}
