<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassCoursesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('Class_courses')->delete();

        DB::table('Class_courses')->insert(array (
            0 =>
            array (
                'class_course_id' => '1',
                'class_id' => '1',
                'course_id' => '1',
                'instructor_id' => 'INS001',
                'created_at' => '2023-06-07 10:02:33.900',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 =>
            array (
                'class_course_id' => '2',
                'class_id' => '1',
                'course_id' => '2',
                'instructor_id' => 'INS002',
                'created_at' => '2023-06-07 10:02:33.900',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 =>
            array (
                'class_course_id' => '3',
                'class_id' => '2',
                'course_id' => '3',
                'instructor_id' => 'INS003',
                'created_at' => '2023-06-07 10:02:33.900',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            3 =>
            array (
                'class_course_id' => '4',
                'class_id' => '2',
                'course_id' => '4',
                'instructor_id' => 'INS004',
                'created_at' => '2023-06-07 10:02:33.900',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            4 =>
            array (
                'class_course_id' => '5',
                'class_id' => '3',
                'course_id' => '5',
                'instructor_id' => 'INS001',
                'created_at' => '2023-06-07 10:02:33.900',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            5 =>
            array (
                'class_course_id' => '6',
                'class_id' => '3',
                'course_id' => '6',
                'instructor_id' => 'INS002',
                'created_at' => '2023-06-07 10:02:33.900',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            6 =>
            array (
                'class_course_id' => '7',
                'class_id' => '4',
                'course_id' => '7',
                'instructor_id' => 'INS003',
                'created_at' => '2023-06-07 10:02:33.900',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            7 =>
            array (
                'class_course_id' => '8',
                'class_id' => '4',
                'course_id' => '8',
                'instructor_id' => 'INS004',
                'created_at' => '2023-06-07 10:02:33.900',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));


    }
}
