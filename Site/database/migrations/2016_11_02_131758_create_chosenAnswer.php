<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChosenAnswer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chosenAnswer', function (Blueprint $table) {
			$table->unsignedinteger('users_id');
			$table->unsignedinteger('round_id');
			$table->unsignedinteger('answer_id')->nullable();
			$table->foreign('users_id')->references('id')->on('users');
			$table->foreign('round_id')->references('id')->on('round');
			$table->foreign('answer_id')->references('id')->on('answer');
			$table->primary(['users_id', 'round_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chosenAnswer');
    }
}
