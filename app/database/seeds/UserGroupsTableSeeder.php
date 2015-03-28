<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class UserGroupsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();
		$random = 0 ; //not that random type but just for seeding
		foreach(range(1, 10) as $value){
			foreach(range(1, 10) as $index)
			{
				UserGroup::create([
					'user_id' => $index ,
					'group_id' =>  $value,
					'active' => ($index != 1 )?$random:1
				]);
				$random++ ;
				if($random>3)	
					$random = 0 ;
			}
		}
		 
	}

}