<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnrollmentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('Enrollments')->delete();

        DB::table('Enrollments')->insert(array (
            0 =>
            array (
                'enrollment_id' => '1',
                'student_id' => 'CS001',
                'course_id' => '1',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.890',
            ),
            1 =>
            array (
                'enrollment_id' => '2',
                'student_id' => 'CS002',
                'course_id' => '1',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.890',
            ),
            2 =>
            array (
                'enrollment_id' => '3',
                'student_id' => 'CS003',
                'course_id' => '2',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.890',
            ),
            3 =>
            array (
                'enrollment_id' => '4',
                'student_id' => 'CS004',
                'course_id' => '2',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.890',
            ),
            4 =>
            array (
                'enrollment_id' => '5',
                'student_id' => 'BA001',
                'course_id' => '3',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.890',
            ),
            5 =>
            array (
                'enrollment_id' => '6',
                'student_id' => 'BA002',
                'course_id' => '3',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.890',
            ),
            6 =>
            array (
                'enrollment_id' => '7',
                'student_id' => 'BA003',
                'course_id' => '4',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.890',
            ),
            7 =>
            array (
                'enrollment_id' => '8',
                'student_id' => 'BA004',
                'course_id' => '4',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.890',
            ),
            8 =>
            array (
                'enrollment_id' => '9',
                'student_id' => 'ME001',
                'course_id' => '5',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.890',
            ),
            9 =>
            array (
                'enrollment_id' => '10',
                'student_id' => 'ME002',
                'course_id' => '5',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.890',
            ),
        ));


    }
}
