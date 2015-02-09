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
            $hell = $faker->name ;
            User::create(array(
                'name'     => $hell,
                //'username' => 'navin',
                'email'    => $hell.'@gmail.com',
                'password' => Hash::make('awesome'),
                'confirmed' => true ,
            ));

        }
    }
}