<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('Grades')->delete();

        DB::table('Grades')->insert(array (
            0 =>
            array (
                'grade_id' => '1',
                'class_enrollment_id' => '1',
                'score' => '80',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.913',
                'updated_at' => NULL,
            ),
            1 =>
            array (
                'grade_id' => '2',
                'class_enrollment_id' => '2',
                'score' => '85',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.913',
                'updated_at' => NULL,
            ),
            2 =>
            array (
                'grade_id' => '3',
                'class_enrollment_id' => '3',
                'score' => '90',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.913',
                'updated_at' => NULL,
            ),
            3 =>
            array (
                'grade_id' => '4',
                'class_enrollment_id' => '4',
                'score' => '75',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.913',
                'updated_at' => NULL,
            ),
            4 =>
            array (
                'grade_id' => '5',
                'class_enrollment_id' => '5',
                'score' => '82',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.913',
                'updated_at' => NULL,
            ),
            5 =>
            array (
                'grade_id' => '6',
                'class_enrollment_id' => '6',
                'score' => '87',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.913',
                'updated_at' => NULL,
            ),
            6 =>
            array (
                'grade_id' => '7',
                'class_enrollment_id' => '7',
                'score' => '92',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.913',
                'updated_at' => NULL,
            ),
            7 =>
            array (
                'grade_id' => '8',
                'class_enrollment_id' => '8',
                'score' => '78',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.913',
                'updated_at' => NULL,
            ),
            8 =>
            array (
                'grade_id' => '9',
                'class_enrollment_id' => '9',
                'score' => '83',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.913',
                'updated_at' => NULL,
            ),
            9 =>
            array (
                'grade_id' => '10',
                'class_enrollment_id' => '10',
                'score' => '88',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.913',
                'updated_at' => NULL,
            ),
            10 =>
            array (
                'grade_id' => '11',
                'class_enrollment_id' => '11',
                'score' => '86',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.913',
                'updated_at' => NULL,
            ),
            11 =>
            array (
                'grade_id' => '12',
                'class_enrollment_id' => '12',
                'score' => '91',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.913',
                'updated_at' => NULL,
            ),
            12 =>
            array (
                'grade_id' => '13',
                'class_enrollment_id' => '13',
                'score' => '76',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.913',
                'updated_at' => NULL,
            ),
            13 =>
            array (
                'grade_id' => '14',
                'class_enrollment_id' => '14',
                'score' => '81',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.913',
                'updated_at' => NULL,
            ),
            14 =>
            array (
                'grade_id' => '15',
                'class_enrollment_id' => '15',
                'score' => '85',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.913',
                'updated_at' => NULL,
            ),
            15 =>
            array (
                'grade_id' => '16',
                'class_enrollment_id' => '16',
                'score' => '79',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.913',
                'updated_at' => NULL,
            ),
            16 =>
            array (
                'grade_id' => '17',
                'class_enrollment_id' => '17',
                'score' => '84',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.913',
                'updated_at' => NULL,
            ),
            17 =>
            array (
                'grade_id' => '18',
                'class_enrollment_id' => '18',
                'score' => '89',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.913',
                'updated_at' => NULL,
            ),
            18 =>
            array (
                'grade_id' => '19',
                'class_enrollment_id' => '19',
                'score' => '87',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.913',
                'updated_at' => NULL,
            ),
        ));


    }
}
