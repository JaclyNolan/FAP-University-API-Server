<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ClassEnrollmentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('Class_enrollments')->delete();
        
        \DB::table('Class_enrollments')->insert(array (
            0 => 
            array (
                'class_enrollment_id' => '1',
                'class_course_id' => '1',
                'student_id' => 'CS001',
                'created_at' => '2023-06-07 10:02:33.907',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'class_enrollment_id' => '2',
                'class_course_id' => '1',
                'student_id' => 'CS002',
                'created_at' => '2023-06-07 10:02:33.907',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'class_enrollment_id' => '3',
                'class_course_id' => '1',
                'student_id' => 'CS003',
                'created_at' => '2023-06-07 10:02:33.907',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'class_enrollment_id' => '4',
                'class_course_id' => '1',
                'student_id' => 'CS004',
                'created_at' => '2023-06-07 10:02:33.907',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'class_enrollment_id' => '5',
                'class_course_id' => '1',
                'student_id' => 'CS004',
                'created_at' => '2023-06-07 10:02:33.907',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'class_enrollment_id' => '6',
                'class_course_id' => '2',
                'student_id' => 'BA001',
                'created_at' => '2023-06-07 10:02:33.907',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'class_enrollment_id' => '7',
                'class_course_id' => '2',
                'student_id' => 'BA002',
                'created_at' => '2023-06-07 10:02:33.907',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'class_enrollment_id' => '8',
                'class_course_id' => '2',
                'student_id' => 'BA003',
                'created_at' => '2023-06-07 10:02:33.907',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'class_enrollment_id' => '9',
                'class_course_id' => '2',
                'student_id' => 'BA004',
                'created_at' => '2023-06-07 10:02:33.907',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'class_enrollment_id' => '10',
                'class_course_id' => '2',
                'student_id' => 'BA005',
                'created_at' => '2023-06-07 10:02:33.907',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'class_enrollment_id' => '11',
                'class_course_id' => '3',
                'student_id' => 'ME001',
                'created_at' => '2023-06-07 10:02:33.907',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'class_enrollment_id' => '12',
                'class_course_id' => '3',
                'student_id' => 'ME002',
                'created_at' => '2023-06-07 10:02:33.907',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'class_enrollment_id' => '13',
                'class_course_id' => '3',
                'student_id' => 'ME003',
                'created_at' => '2023-06-07 10:02:33.907',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'class_enrollment_id' => '14',
                'class_course_id' => '3',
                'student_id' => 'ME004',
                'created_at' => '2023-06-07 10:02:33.907',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'class_enrollment_id' => '15',
                'class_course_id' => '3',
                'student_id' => 'ME004',
                'created_at' => '2023-06-07 10:02:33.907',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'class_enrollment_id' => '16',
                'class_course_id' => '4',
                'student_id' => 'P001',
                'created_at' => '2023-06-07 10:02:33.907',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'class_enrollment_id' => '17',
                'class_course_id' => '4',
                'student_id' => 'P002',
                'created_at' => '2023-06-07 10:02:33.907',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'class_enrollment_id' => '18',
                'class_course_id' => '4',
                'student_id' => 'P003',
                'created_at' => '2023-06-07 10:02:33.907',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'class_enrollment_id' => '19',
                'class_course_id' => '4',
                'student_id' => 'P004',
                'created_at' => '2023-06-07 10:02:33.907',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}