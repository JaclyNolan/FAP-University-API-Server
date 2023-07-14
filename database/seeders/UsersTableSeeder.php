<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('Users')->delete();

        DB::table('Users')->insert(array (
            0 =>
            array (
                'user_id' => '1',
                'role_id' => '1',
                'student_id' => NULL,
                'staff_id' => 'ST001',
                'instructor_id' => NULL,
                'username' => 'Jacly',
                'email' => 'anhbg330011@gmail.com',
                'created_at' => '2023-06-07 10:02:33.883',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 =>
            array (
                'user_id' => '2',
                'role_id' => '3',
                'student_id' => NULL,
                'staff_id' => NULL,
                'instructor_id' => 'INS001',
                'username' => 'Nguyen Minh Anh (BTEC HN)',
                'email' => 'anhnmbh00203@fpt.edu.vn',
                'created_at' => '2023-06-07 10:02:33.883',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 =>
            array (
                'user_id' => '3',
                'role_id' => '2',
                'student_id' => NULL,
                'staff_id' => 'ST003',
                'instructor_id' => NULL,
                'username' => 'staff_user3',
                'email' => 'staffuser3@example.com',
                'created_at' => '2023-06-07 10:02:33.883',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            3 =>
            array (
                'user_id' => '4',
                'role_id' => '2',
                'student_id' => NULL,
                'staff_id' => 'ST004',
                'instructor_id' => NULL,
                'username' => 'staff_user4',
                'email' => 'staffuser4@example.com',
                'created_at' => '2023-06-07 10:02:33.883',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            4 =>
            array (
                'user_id' => '5',
                'role_id' => '4',
                'student_id' => 'CS001',
                'staff_id' => NULL,
                'instructor_id' => NULL,
                'username' => '',
                'email' => 'ivansally0@gmail.com',
                'created_at' => '2023-06-07 10:02:33.883',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            5 =>
            array (
                'user_id' => '6',
                'role_id' => '4',
                'student_id' => 'BA001',
                'staff_id' => NULL,
                'instructor_id' => NULL,
                'username' => 'student_user2',
                'email' => 'studentuser2@example.com',
                'created_at' => '2023-06-07 10:02:33.883',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            6 =>
            array (
                'user_id' => '7',
                'role_id' => '4',
                'student_id' => 'ME002',
                'staff_id' => NULL,
                'instructor_id' => NULL,
                'username' => 'student_user3',
                'email' => 'studentuser3@example.com',
                'created_at' => '2023-06-07 10:02:33.883',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            7 =>
            array (
                'user_id' => '8',
                'role_id' => '4',
                'student_id' => 'P003',
                'staff_id' => NULL,
                'instructor_id' => NULL,
                'username' => 'student_user4',
                'email' => 'studentuser4@example.com',
                'created_at' => '2023-06-07 10:02:33.883',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            8 =>
            array (
                'user_id' => '9',
                'role_id' => '3',
                'student_id' => NULL,
                'staff_id' => NULL,
                'instructor_id' => 'INS001',
                'username' => 'instructor_user1',
                'email' => 'instructoruser1@example.com',
                'created_at' => '2023-06-07 10:02:33.883',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            9 =>
            array (
                'user_id' => '10',
                'role_id' => '3',
                'student_id' => NULL,
                'staff_id' => NULL,
                'instructor_id' => 'INS002',
                'username' => 'instructor_user2',
                'email' => 'instructoruser2@example.com',
                'created_at' => '2023-06-07 10:02:33.883',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            10 =>
            array (
                'user_id' => '11',
                'role_id' => '3',
                'student_id' => NULL,
                'staff_id' => NULL,
                'instructor_id' => 'INS003',
                'username' => 'instructor_user3',
                'email' => 'instructoruser3@example.com',
                'created_at' => '2023-06-07 10:02:33.883',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            11 =>
            array (
                'user_id' => '12',
                'role_id' => '3',
                'student_id' => NULL,
                'staff_id' => NULL,
                'instructor_id' => 'INS004',
                'username' => 'instructor_user4',
                'email' => 'instructoruser4@example.com',
                'created_at' => '2023-06-07 10:02:33.883',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));


    }
}
