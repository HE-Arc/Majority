<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
	public $timestamps = false;
    protected $fillable = [
	
        'user_id', 'game_id', 'state'
    ];
}
