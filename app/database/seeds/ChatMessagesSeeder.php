<?php

class ChatMessagesSeeder extends Seeder{
    public function run(){

        DB::table('chat_messages')->delete();
        $now = date('Y-m-d H:i:s');

        $users = array(
            array(
                'nickname'=>'tunte',
                'message' => 'Test1',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            array(
                'nickname'=>'Naum',
                'message' => 'Test2',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            array(
                'nickname'=>'Riste',
                'message' => 'Test3',
                'created_at' => $now,
                'updated_at' => $now,
            )
        );

        DB::table('chat_messages')->insert($users);

    }
}