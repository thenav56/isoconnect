<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserGroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_groups', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('group_id') ;
			$table->enum('active' , array(1,0,2,3))->default(0);    //0 user send the request
			$table->timestamps();									//1 admin accept the request
		});															//2 admin blocks the user
	}																//3 admin sends the request


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_groups');
	}

}
