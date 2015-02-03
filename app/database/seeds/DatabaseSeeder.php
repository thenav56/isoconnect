<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('UserTableSeeder');
		$this->call('CommentsTableSeeder');
		$this->call('GroupsTableSeeder');
		$this->call('PostsTableSeeder');
		$this->call('UserGroupsTableSeeder');
		$this->call('NotificationsTableSeeder') ;
		$this->call('MessagesTableSeeder') ;
	}

}
