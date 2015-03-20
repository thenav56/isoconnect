	<?php

 
use Faker\Factory as Faker;

class PostsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 5) as $index)
		{
			Post::create([
				'user_id'	=> $index ,
				'post_body' => $faker->text,
				'like'		=>  $index,
				'dislike'	=>  $index,
				'group_id'	=>  1,
			]);
		}

		foreach(range(6, 10) as $index)
		{
			Post::create([
				'user_id'	=> $index ,
				'post_body' => $faker->text,
				'like'		=>  $index,
				'dislike'	=>  $index,
				'group_id'	=>  $index-4,
			]);
		}
	}

}