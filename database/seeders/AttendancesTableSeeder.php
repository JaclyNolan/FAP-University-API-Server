<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AttendancesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('Attendances')->delete();
        
        \DB::table('Attendances')->insert(array (
            0 => 
            array (
                'attendance_id' => '1',
                'class_schedule_id' => '1',
                'class_enrollment_id' => '1',
                'attendance_status' => '1',
                'attendance_time' => '2023-05-18',
                'update_at' => NULL,
            ),
            1 => 
            array (
                'attendance_id' => '2',
                'class_schedule_id' => '1',
                'class_enrollment_id' => '2',
                'attendance_status' => '1',
                'attendance_time' => '2023-05-18',
                'update_at' => NULL,
            ),
            2 => 
            array (
                'attendance_id' => '3',
                'class_schedule_id' => '1',
                'class_enrollment_id' => '3',
                'attendance_status' => '0',
                'attendance_time' => '2023-05-18',
                'update_at' => NULL,
            ),
            3 => 
            array (
                'attendance_id' => '4',
                'class_schedule_id' => '2',
                'class_enrollment_id' => '4',
                'attendance_status' => '1',
                'attendance_time' => '2023-05-19',
                'update_at' => NULL,
            ),
            4 => 
            array (
                'attendance_id' => '5',
                'class_schedule_id' => '2',
                'class_enrollment_id' => '5',
                'attendance_status' => '0',
                'attendance_time' => '2023-05-19',
                'update_at' => NULL,
            ),
            5 => 
            array (
                'attendance_id' => '6',
                'class_schedule_id' => '2',
                'class_enrollment_id' => '6',
                'attendance_status' => '1',
                'attendance_time' => '2023-05-19',
                'update_at' => NULL,
            ),
            6 => 
            array (
                'attendance_id' => '7',
                'class_schedule_id' => '3',
                'class_enrollment_id' => '7',
                'attendance_status' => '1',
                'attendance_time' => '2023-05-20',
                'update_at' => NULL,
            ),
            7 => 
            array (
                'attendance_id' => '8',
                'class_schedule_id' => '3',
                'class_enrollment_id' => '8',
                'attendance_status' => '1',
                'attendance_time' => '2023-05-20',
                'update_at' => NULL,
            ),
            8 => 
            array (
                'attendance_id' => '9',
                'class_schedule_id' => '3',
                'class_enrollment_id' => '9',
                'attendance_status' => '0',
                'attendance_time' => '2023-05-20',
                'update_at' => NULL,
            ),
            9 => 
            array (
                'attendance_id' => '10',
                'class_schedule_id' => '4',
                'class_enrollment_id' => '10',
                'attendance_status' => '1',
                'attendance_time' => '2023-05-21',
                'update_at' => NULL,
            ),
            10 => 
            array (
                'attendance_id' => '11',
                'class_schedule_id' => '4',
                'class_enrollment_id' => '11',
                'attendance_status' => '1',
                'attendance_time' => '2023-05-21',
                'update_at' => NULL,
            ),
            11 => 
            array (
                'attendance_id' => '12',
                'class_schedule_id' => '4',
                'class_enrollment_id' => '12',
                'attendance_status' => '1',
                'attendance_time' => '2023-05-21',
                'update_at' => NULL,
            ),
        ));
        
        
    }
}