<?php

 
use Faker\Factory as Faker;

class UserTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->delete();
        $faker = Faker::create();
        User::create(array(
                'name'     => 'Navin Ayer',
                //'username' => 'navin',
                'email'    => 'navinayer56@gmail.com',
                'password' => Hash::make('awesome'),
                'confirmed' => true ,
            ));

         User::create(array(
                'name'     => 'Pramod Maharjen ',
                //'username' => 'navin',
                'email'    => 'unknown.emlap@gmail.com',
                'password' => Hash::make('awesome'),
                'confirmed' => true ,
            ));

          User::create(array(
                'name'     => 'Prabesh Pathak',
                //'username' => 'navin',
                'email'    => 'prabesh.pathak@hotmail.com',
                'password' => Hash::make('awesome'),
                'confirmed' => true ,
            ));

        foreach(range(1 , 10) as $index){
            User::create(array(
                'name'     => $faker->name,
                //'username' => 'navin',
                'email'    => $faker->email,
                'password' => Hash::make('awesome'),
                'confirmed' => true ,
            ));

        }
    }
}