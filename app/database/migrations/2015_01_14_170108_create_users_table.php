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
		Schema::create('users', function($table)
	    {
	        $table->increments('id');

			//$table->string('username',32)->unique() ;
	        $table->string('email')->unique();
	        $table->string('name',32);
			$table->string('password',64) ;
			$table->string('address',64)->nullable() ;
			$table->date('dob',32)->nullable() ;
			$table->string('gender',32) ;
			$table->string('contact',32)->nullable() ;
			$table->string('company',32)->nullable() ;
			$table->string('profile_pic')->nullable();

			$table->string('confirmation_code')->nullable();
			$table->boolean('confirmed')->default(0) ;
			// required for Laravel 4.1.26
			$table->string('remember_token', 100)->nullable();

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
		Schema::drop('users');
	}

}
