<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    protected $fillable = [
        'n_round', 'question_id',
    ];
}
