<?php

class CourseTableSeeder extends Seeder{
    public function run(){

        DB::table('courses')->delete();
        $now = date('Y-m-d H:i:s');

        $courses = array(
            array(
                'name' => 'Programming 4',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            array(
                'name' => 'Programming 1',
                'created_at' => $now,
                'updated_at' => $now,
            )
        );

        DB::table('courses')->insert($courses);

    }
}