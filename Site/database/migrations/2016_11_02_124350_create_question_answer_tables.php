<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionAnswerTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		
        Schema::create('question', function (Blueprint $table) {
            $table->increments('id');
            $table->string('question');
        });
        Schema::create('answer', function (Blueprint $table) {
            $table->increments('id');
            $table->string('answer');
			$table->unsignedinteger('question_id');
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
        Schema::drop('answer');
        Schema::drop('question');
    }
}
