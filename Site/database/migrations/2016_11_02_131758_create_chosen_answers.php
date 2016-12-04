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
			$table->unsignedinteger('round_id');
			$table->unsignedinteger('answer_id')->nullable();
            $table->timestamps();
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('round_id')->references('id')->on('rounds');
			$table->foreign('answer_id')->references('id')->on('answers');
			$table->primary(['user_id', 'round_id']);
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
