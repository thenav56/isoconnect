<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notifications', function(Blueprint $table)
		{
			$activity_type = array('comment','post','groupPost','like','disLike',
				'accepted','rejected','blocked');

			$table->increments('id');
			$table->integer('user_id') ;
			$table->enum('activity_type' , $activity_type) ;
			$table->integer('source_id');
			$table->integer('parent_id');
			$table->enum('parent_type' ,$activity_type) ;
			$table->enum('seen' , array(0,1))->default(0) ; 
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
		Schema::drop('notifications');
	}

}
