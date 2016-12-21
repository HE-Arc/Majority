<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChosenAnswer extends Model
{
    protected $fillable = ['n_round', 'game_id', 'user_id'];
}
