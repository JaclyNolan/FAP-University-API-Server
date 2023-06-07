<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FeedbacksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('Feedbacks')->delete();
        
        \DB::table('Feedbacks')->insert(array (
            0 => 
            array (
                'feedback_id' => '1',
                'class_enrollment_id' => '1',
                'feedback_content' => 'Sample feedback 1',
                'created_at' => '2023-06-07 10:02:33.917',
            ),
            1 => 
            array (
                'feedback_id' => '2',
                'class_enrollment_id' => '2',
                'feedback_content' => 'Sample feedback 2',
                'created_at' => '2023-06-07 10:02:33.917',
            ),
            2 => 
            array (
                'feedback_id' => '3',
                'class_enrollment_id' => '3',
                'feedback_content' => 'Sample feedback 3',
                'created_at' => '2023-06-07 10:02:33.917',
            ),
            3 => 
            array (
                'feedback_id' => '4',
                'class_enrollment_id' => '4',
                'feedback_content' => 'Sample feedback 4',
                'created_at' => '2023-06-07 10:02:33.917',
            ),
            4 => 
            array (
                'feedback_id' => '5',
                'class_enrollment_id' => '5',
                'feedback_content' => 'Sample feedback 5',
                'created_at' => '2023-06-07 10:02:33.917',
            ),
            5 => 
            array (
                'feedback_id' => '6',
                'class_enrollment_id' => '6',
                'feedback_content' => 'Sample feedback 6',
                'created_at' => '2023-06-07 10:02:33.917',
            ),
            6 => 
            array (
                'feedback_id' => '7',
                'class_enrollment_id' => '7',
                'feedback_content' => 'Sample feedback 7',
                'created_at' => '2023-06-07 10:02:33.917',
            ),
            7 => 
            array (
                'feedback_id' => '8',
                'class_enrollment_id' => '8',
                'feedback_content' => 'Sample feedback 8',
                'created_at' => '2023-06-07 10:02:33.917',
            ),
            8 => 
            array (
                'feedback_id' => '9',
                'class_enrollment_id' => '9',
                'feedback_content' => 'Sample feedback 9',
                'created_at' => '2023-06-07 10:02:33.917',
            ),
            9 => 
            array (
                'feedback_id' => '10',
                'class_enrollment_id' => '10',
                'feedback_content' => 'Sample feedback 10',
                'created_at' => '2023-06-07 10:02:33.917',
            ),
            10 => 
            array (
                'feedback_id' => '11',
                'class_enrollment_id' => '11',
                'feedback_content' => 'Sample feedback 11',
                'created_at' => '2023-06-07 10:02:33.917',
            ),
            11 => 
            array (
                'feedback_id' => '12',
                'class_enrollment_id' => '12',
                'feedback_content' => 'Sample feedback 12',
                'created_at' => '2023-06-07 10:02:33.917',
            ),
            12 => 
            array (
                'feedback_id' => '13',
                'class_enrollment_id' => '13',
                'feedback_content' => 'Sample feedback 13',
                'created_at' => '2023-06-07 10:02:33.917',
            ),
            13 => 
            array (
                'feedback_id' => '14',
                'class_enrollment_id' => '14',
                'feedback_content' => 'Sample feedback 14',
                'created_at' => '2023-06-07 10:02:33.917',
            ),
            14 => 
            array (
                'feedback_id' => '15',
                'class_enrollment_id' => '15',
                'feedback_content' => 'Sample feedback 15',
                'created_at' => '2023-06-07 10:02:33.917',
            ),
            15 => 
            array (
                'feedback_id' => '16',
                'class_enrollment_id' => '16',
                'feedback_content' => 'Sample feedback 16',
                'created_at' => '2023-06-07 10:02:33.917',
            ),
            16 => 
            array (
                'feedback_id' => '17',
                'class_enrollment_id' => '17',
                'feedback_content' => 'Sample feedback 17',
                'created_at' => '2023-06-07 10:02:33.917',
            ),
            17 => 
            array (
                'feedback_id' => '18',
                'class_enrollment_id' => '18',
                'feedback_content' => 'Sample feedback 18',
                'created_at' => '2023-06-07 10:02:33.917',
            ),
            18 => 
            array (
                'feedback_id' => '19',
                'class_enrollment_id' => '19',
                'feedback_content' => 'Sample feedback 19',
                'created_at' => '2023-06-07 10:02:33.917',
            ),
        ));
        
        
    }
}