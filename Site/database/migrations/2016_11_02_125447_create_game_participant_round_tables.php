<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameParticipantRoundTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedinteger('max_duration');
            $table->unsignedinteger('owner_id');
			$table->foreign('owner_id')->references('id')->on('users');
        });
        Schema::create('participant', function (Blueprint $table) {
            $table->unsignedinteger('user_id');
            $table->unsignedinteger('game_id');
            $table->Integer('state');
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('game_id')->references('id')->on('game');
			$table->primary(['user_id', 'game_id']);
        });
        Schema::create('round', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedinteger('game_id');
            $table->unsignedinteger('question_id');
			$table->foreign('game_id')->references('id')->on('game');
			$table->foreign('question_id')->references('id')->on('question');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('round');
        Schema::drop('participant');
        Schema::drop('game');
    }
}
