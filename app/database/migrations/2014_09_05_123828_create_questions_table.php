<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sspquestions', function(Blueprint $table)
		{
                    $table->increments('id');
                    $table->integer('sspquizz_id')->references('id')->on('sspquizzes');
                    $table->integer('question_number');
                    $table->text('type');
                    $table->text('question');
                    $table->text('answers');
                    $table->text('correct');
                    $table->softDeletes();
                    $table->timestamps();
                });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sspquestions');
	}

}
