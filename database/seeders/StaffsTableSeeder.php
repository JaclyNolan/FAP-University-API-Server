<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StaffsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('Staffs')->delete();
        
        \DB::table('Staffs')->insert(array (
            0 => 
            array (
                'staff_id' => 'ST001',
                'full_name' => 'John Smith',
                'phone_number' => '123457890',
                'gender' => '1',
                'date_of_birth' => '1980-03-15',
                'address' => '123 Main St, City',
                'image' => 'image1.jpg',
                'department' => 'Administration',
                'position' => '1',
                'created_at' => '2023-06-07 10:02:33.867',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'staff_id' => 'ST002',
                'full_name' => 'Sarah Johnson',
                'phone_number' => '987654310',
                'gender' => '0',
                'date_of_birth' => '1975-08-20',
                'address' => '456 Elm St, City',
                'image' => 'image2.jpg',
                'department' => 'Academic Affairs',
                'position' => '2',
                'created_at' => '2023-06-07 10:02:33.867',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'staff_id' => 'ST003',
                'full_name' => 'Michael Brown',
                'phone_number' => '456789230',
                'gender' => '1',
                'date_of_birth' => '1982-05-10',
                'address' => '789 Oak St, City',
                'image' => 'image3.jpg',
                'department' => 'Student Services',
                'position' => '1',
                'created_at' => '2023-06-07 10:02:33.867',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'staff_id' => 'ST004',
                'full_name' => 'Emily Davis',
                'phone_number' => '321654980',
                'gender' => '0',
                'date_of_birth' => '1979-12-25',
                'address' => '987 Maple St, City',
                'image' => 'image4.jpg',
                'department' => 'Admissions',
                'position' => '2',
                'created_at' => '2023-06-07 10:02:33.867',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'staff_id' => 'ST005',
                'full_name' => 'Robert Anderson',
                'phone_number' => '789234560',
                'gender' => '1',
                'date_of_birth' => '1981-07-05',
                'address' => '456 Pine St, City',
                'image' => 'image5.jpg',
                'department' => 'Finance',
                'position' => '1',
                'created_at' => '2023-06-07 10:02:33.867',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}