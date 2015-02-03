<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class MessagesTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 10) as $index)
		{
			Message::create([
				'user1_id'  =>1 , 
				'user2_id'  =>11-$index ,
				'message'	=> $faker->text
			]);
		}

		foreach(range(1, 10) as $index)
		{
			Message::create([
				'user1_id'  =>11-$index , 
				'user2_id'  =>1 ,
				'message'	=> $faker->text
			]);
		}
	}

}