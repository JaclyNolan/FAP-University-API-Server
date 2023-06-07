<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('Roles')->delete();
        
        \DB::table('Roles')->insert(array (
            0 => 
            array (
                'role_id' => '1',
                'role_name' => 'Admin',
            ),
            1 => 
            array (
                'role_id' => '3',
                'role_name' => 'Instructor',
            ),
            2 => 
            array (
                'role_id' => '2',
                'role_name' => 'Staff',
            ),
            3 => 
            array (
                'role_id' => '4',
                'role_name' => 'Student',
            ),
        ));
        
        
    }
}