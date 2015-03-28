<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class CommentsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach (range(1,10) as $value) {
			foreach(range(1, 10) as $index)
			{
				Comment::create([
				'post_id' =>  $value ,
				'user_id'=>  $index ,
				'comment_body' => $faker->text  ,
				'like'=>  0 ,
				'dislike'=> 0 
				]);
			}
		}
		
	}

}