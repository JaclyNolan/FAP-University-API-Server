<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MajorsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('Majors')->delete();

        DB::table('Majors')->insert(array (
            0 =>
            array (
                'major_id' => '2',
                'major_name' => 'Business Administration',
                'short_name' => 'BA',
            ),
            1 =>
            array (
                'major_id' => '1',
                'major_name' => 'Computer Science',
                'short_name' => 'CS',
            ),
            2 =>
            array (
                'major_id' => '3',
                'major_name' => 'Mechanical Engineering',
                'short_name' => 'ME',
            ),
            3 =>
            array (
                'major_id' => '4',
                'major_name' => 'Psychology',
                'short_name' => 'P',
            ),
        ));


    }
}
