<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
	protected $fillable = [
        'max_duration', 'max_player', 'description',
    ];
	
    public function rounds()
    {
        return $this->hasMany('App\Round', 'game_id');
    }
}
