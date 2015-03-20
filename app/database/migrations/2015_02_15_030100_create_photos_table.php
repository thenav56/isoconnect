<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePhotosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('photos', function(Blueprint $table)
		{
			$source_type = ['post','profile','group' , 'user_photo'] ;
			
			$table->increments('id');
			$table->integer('user_id'); //source of the photo
			$table->integer('source_id'); //where or why the photo was uploaded
			$table->enum('source_type' , $source_type) ; //source type..it can be post_pic ,profile_pic or...
			$table->string('location');
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
		Schema::drop('photos');
	}

}
