	<?php

 
use Faker\Factory as Faker;

class PostsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();
		$random = 1 ;
		foreach(range(1, 10) as $value){
			foreach(range(1, 10) as $index)
			{
				Post::create([
					'user_id'	=> $index ,
					'post_body' => $faker->text,
					'like'		=>  $index,
					'dislike'	=>  0,
					'group_id'	=>  $random,
				]);
				$random++ ;
				if($random>=10)
					$random = 1; 
			}
		}
 
	}

}