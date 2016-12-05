<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesParticipantsRoundsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedinteger('max_duration');
            $table->unsignedinteger('max_player');
            $table->string('description');
            $table->unsignedinteger('owner_id');
            $table->timestamps();
            $table->foreign('owner_id')->references('id')->on('users');
        });
        Schema::create('participants', function (Blueprint $table) {
            $table->unsignedinteger('user_id');
            $table->unsignedinteger('game_id');
            $table->Integer('state');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('game_id')->references('id')->on('games');
            $table->primary(['user_id', 'game_id']);
        });
        Schema::create('rounds', function (Blueprint $table) {
            $table->unsignedinteger('n_round');
            $table->unsignedinteger('game_id');
            $table->unsignedinteger('question_id');
            $table->timestamps();
            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('question_id')->references('id')->on('questions');
            $table->primary(['n_round', 'game_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rounds');
        Schema::drop('participants');
        Schema::drop('games');
    }
}
