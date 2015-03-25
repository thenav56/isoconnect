<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGroupNoticesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('group_notices', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id') ;
			$table->text('post_body' , 2000) ;
			$table->integer('group_id')->default(0) ; 
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
		Schema::drop('group_notices');
	}

}
