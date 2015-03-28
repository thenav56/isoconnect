<?php

 
use Faker\Factory as Faker;

class NoticeTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('group_notices')->delete();
        $faker = Faker::create();
        foreach(range(1 , 10) as $value){
            foreach(range(1 , 10) as $index){
                GroupNotice::create([
                    'post_body' => $faker->text,
                    'user_id' => $value+1,
                    'group_id' => $value ,
                ]);

            }
        }
    }
}