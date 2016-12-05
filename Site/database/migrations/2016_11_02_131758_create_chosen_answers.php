<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChosenAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chosen_answers', function (Blueprint $table) {
            $table->unsignedinteger('user_id');
            $table->unsignedinteger('n_round');
            $table->unsignedinteger('game_id');
            $table->unsignedinteger('answer_id')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('n_round')->references('n_round')->on('rounds');
            $table->foreign('game_id')->references('game_id')->on('rounds');
            $table->foreign('answer_id')->references('id')->on('answers');
            $table->primary(['user_id', 'n_round', 'game_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chosen_answers');
    }
}
