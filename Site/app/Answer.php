<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public function chosenAnswers()
    {
        return $this->hasMany('App\ChosenAnswer');
    }
}
