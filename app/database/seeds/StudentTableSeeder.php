<?php

class StudentTableSeeder extends Seeder{
    public function run(){

        $faker = Faker\Factory::create();

        Student::truncate();

        foreach(range(1,1000) as $index)
        {
            Student::create([
                'username' => str_replace('.', '_', $faker->unique()->userName),
                'email' => $faker->email,
            ]);
        }

    }
}