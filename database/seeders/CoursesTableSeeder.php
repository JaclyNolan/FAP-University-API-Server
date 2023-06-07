<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('Courses')->delete();
        
        \DB::table('Courses')->insert(array (
            0 => 
            array (
                'course_id' => '1',
                'major_id' => '1',
                'course_name' => 'Introduction to Programming',
                'credits' => '3',
                'created_at' => '2023-06-07 10:02:33.823',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'course_id' => '2',
                'major_id' => '1',
                'course_name' => 'Data Structures and Algorithms',
                'credits' => '4',
                'created_at' => '2023-06-07 10:02:33.823',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'course_id' => '3',
                'major_id' => '1',
                'course_name' => 'Database Management Systems',
                'credits' => '3',
                'created_at' => '2023-06-07 10:02:33.823',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'course_id' => '4',
                'major_id' => '2',
                'course_name' => 'Principles of Management',
                'credits' => '3',
                'created_at' => '2023-06-07 10:02:33.823',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'course_id' => '5',
                'major_id' => '2',
                'course_name' => 'Marketing Fundamentals',
                'credits' => '3',
                'created_at' => '2023-06-07 10:02:33.823',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'course_id' => '6',
                'major_id' => '2',
                'course_name' => 'Financial Accounting',
                'credits' => '4',
                'created_at' => '2023-06-07 10:02:33.823',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'course_id' => '7',
                'major_id' => '3',
                'course_name' => 'Thermodynamics',
                'credits' => '4',
                'created_at' => '2023-06-07 10:02:33.823',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'course_id' => '8',
                'major_id' => '3',
                'course_name' => 'Fluid Mechanics',
                'credits' => '3',
                'created_at' => '2023-06-07 10:02:33.823',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'course_id' => '9',
                'major_id' => '3',
                'course_name' => 'Mechanical Design',
                'credits' => '4',
                'created_at' => '2023-06-07 10:02:33.823',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'course_id' => '10',
                'major_id' => '4',
                'course_name' => 'Introduction to Psychology',
                'credits' => '3',
                'created_at' => '2023-06-07 10:02:33.823',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'course_id' => '11',
                'major_id' => '4',
                'course_name' => 'Cognitive Psychology',
                'credits' => '3',
                'created_at' => '2023-06-07 10:02:33.823',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'course_id' => '12',
                'major_id' => '4',
                'course_name' => 'Abnormal Psychology',
                'credits' => '4',
                'created_at' => '2023-06-07 10:02:33.823',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}