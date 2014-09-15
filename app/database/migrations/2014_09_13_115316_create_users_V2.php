<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersV2 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table){
			$table->increments('id');
			$table->text('email');
			$table->text('username');
			$table->text('password');
			$table->text('password_temp');
			$table->text('code');
			$table->integer('active');
			$table->timestamps();
			// sitas paskutinis prideda du fieldus - createdat updatedat
			$table->rememberToken();
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
		Schema::drop('users');
	}

}
