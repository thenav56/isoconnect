<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table)
		{	
			$table->increments('id');
			$table->integer('user_id') ;
			$table->text('post_body' , 1000) ;
			$table->integer('like')->default(0) ;
			$table->integer('dislike');
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
		Schema::drop('posts');
	}

}
