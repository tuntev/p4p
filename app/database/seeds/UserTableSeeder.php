<?php

class UserTableSeeder extends Seeder{
    public function run(){

        DB::table('users')->delete();
        $now = date('Y-m-d H:i:s');

        $users = array(
            array(
                'username'=>'tunte',
                'password'=>Hash::make('123'),
                'firstName'=>'Наум',
                'lastName'=>'Тунтев',
                'type'=> 'system',
                'email'=>'tuntev@gmail.com',
                'access'=>5,
                'created_at' => $now,
                'updated_at' => $now,
            )
        );

        DB::table('users')->insert($users);

    }
}