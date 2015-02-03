<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class GroupsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

			Group::create([
				'admin_id' => 1   , 
				'name' =>  'IOE-BCT-069' ,
				'about' => 'This is the group for BATCH STUDENT OF 69 BCT '
			]);

		foreach(range(1, 10) as $index)
		{
			Group::create([
				'admin_id' => $index   , 
				'name' =>  $faker->company ,
				'about' => $faker->text
			]);
		}
	}

}