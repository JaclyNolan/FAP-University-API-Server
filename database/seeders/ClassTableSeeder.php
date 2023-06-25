<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('Class')->delete();

        DB::table('Class')->insert(array (
            0 =>
            array (
                'class_id' => '1',
                'major_id' => '1',
                'class_name' => 'CS001',
                'created_at' => '2023-06-07 10:02:33.897',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 =>
            array (
                'class_id' => '2',
                'major_id' => '2',
                'class_name' => 'BA001',
                'created_at' => '2023-06-07 10:02:33.897',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 =>
            array (
                'class_id' => '3',
                'major_id' => '3',
                'class_name' => 'ME001',
                'created_at' => '2023-06-07 10:02:33.897',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            3 =>
            array (
                'class_id' => '4',
                'major_id' => '4',
                'class_name' => 'P001',
                'created_at' => '2023-06-07 10:02:33.897',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));


    }
}
