<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstructorsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('Instructors')->delete();

        DB::table('Instructors')->insert(array (
            0 =>
            array (
                'instructor_id' => 'INS001',
                'major_id' => '1',
                'full_name' => 'John Smith',
                'date_of_birth' => '1980-03-15',
                'phone_number' => '123456790',
                'gender' => '1',
                'address' => '123 Main St, City',
                'image' => 'image1.jpg',
                'position' => '1',
                'created_at' => '2023-06-07 10:02:33.863',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 =>
            array (
                'instructor_id' => 'INS002',
                'major_id' => '1',
                'full_name' => 'Sarah Johnson',
                'date_of_birth' => '1975-08-20',
                'phone_number' => '986543210',
                'gender' => '0',
                'address' => '456 Elm St, City',
                'image' => 'image2.jpg',
                'position' => '2',
                'created_at' => '2023-06-07 10:02:33.863',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 =>
            array (
                'instructor_id' => 'INS003',
                'major_id' => '2',
                'full_name' => 'Michael Brown',
                'date_of_birth' => '1982-05-10',
                'phone_number' => '457891230',
                'gender' => '1',
                'address' => '789 Oak St, City',
                'image' => 'image3.jpg',
                'position' => '1',
                'created_at' => '2023-06-07 10:02:33.863',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            3 =>
            array (
                'instructor_id' => 'INS004',
                'major_id' => '2',
                'full_name' => 'Emily Davis',
                'date_of_birth' => '1979-12-25',
                'phone_number' => '321659870',
                'gender' => '0',
                'address' => '987 Maple St, City',
                'image' => 'image4.jpg',
                'position' => '2',
                'created_at' => '2023-06-07 10:02:33.863',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            4 =>
            array (
                'instructor_id' => 'INS005',
                'major_id' => '3',
                'full_name' => 'Robert Anderson',
                'date_of_birth' => '1981-07-05',
                'phone_number' => '789234560',
                'gender' => '1',
                'address' => '456 Pine St, City',
                'image' => 'image5.jpg',
                'position' => '1',
                'created_at' => '2023-06-07 10:02:33.863',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            5 =>
            array (
                'instructor_id' => 'INS006',
                'major_id' => '3',
                'full_name' => 'Sophia Wilson',
                'date_of_birth' => '1976-11-30',
                'phone_number' => '654987210',
                'gender' => '0',
                'address' => '654 Cedar St, City',
                'image' => 'image6.jpg',
                'position' => '2',
                'created_at' => '2023-06-07 10:02:33.863',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            6 =>
            array (
                'instructor_id' => 'INS007',
                'major_id' => '4',
                'full_name' => 'William Thompson',
                'date_of_birth' => '1983-02-10',
                'phone_number' => '987316540',
                'gender' => '1',
                'address' => '789 Walnut St, City',
                'image' => 'image7.jpg',
                'position' => '1',
                'created_at' => '2023-06-07 10:02:33.863',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            7 =>
            array (
                'instructor_id' => 'INS008',
                'major_id' => '4',
                'full_name' => 'Olivia Hernandez',
                'date_of_birth' => '1978-09-15',
                'phone_number' => '123467891',
                'gender' => '0',
                'address' => '123 Birch St, City',
                'image' => 'image8.jpg',
                'position' => '2',
                'created_at' => '2023-06-07 10:02:33.863',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));


    }
}
