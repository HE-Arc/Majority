<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chosen_answer extends Model
{
    protected $fillable = ['n_round', 'game_id', 'user_id'];
}
