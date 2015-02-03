<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class UserGroupsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 5) as $index)
		{
			UserGroup::create([
				'user_id' => $index ,
				'group_id' =>  1,
				'active' => 0
			]);
		}

		foreach(range(6, 10) as $index)
		{
			UserGroup::create([
				'user_id' => $index ,
				'group_id' =>  $index-4,
				'active' => 1
			]);
		}
	}

}