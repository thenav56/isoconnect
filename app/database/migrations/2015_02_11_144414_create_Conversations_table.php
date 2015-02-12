<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConversationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('conversations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user1_id'); //creater of the conversation 
			$table->integer('user2_id'); //another buddy
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
		Schema::drop('Conversations');
	}

}
