<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
            Schema::create('sspusers', function($table) {
                $table->increments('id');

                $table->text('firstName');
                $table->text('lastName');
                $table->text('username');
                $table->text('email');
                $table->text('password');
                $table->text('password_temp');
                $table->text('code');
                $table->integer('member');
                $table->text('remember_token');
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
		//
            Schema::drop('sspusers');
	}

}
