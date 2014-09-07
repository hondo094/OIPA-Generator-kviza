<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizzesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sspquizzes', function(Blueprint $table)
		{
			$table->increments('id');                        
                        $table->text('quizzName');
                        $table->text('creator');
                        $table->text('quizzTitle');              
                        $table->text('level');
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
		Schema::drop('sspquizzes');
	}

}
