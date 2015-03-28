	<?php

 
use Faker\Factory as Faker;

class PostsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();
		foreach(range(1, 10) as $value){
			foreach(range(1, 10) as $index)
			{
				Post::create([
					'user_id'	=> $value ,
					'post_body' => $faker->text,
					'like'		=>  $index,
					'dislike'	=>  0,
					'group_id'	=>  $index,
				]);
			}
		}
 
	}

}