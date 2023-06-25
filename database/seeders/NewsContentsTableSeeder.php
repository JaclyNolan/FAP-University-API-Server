<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsContentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('News_contents')->delete();

        DB::table('News_contents')->insert(array (
            0 =>
            array (
                'news_id' => '1',
                'title' => 'New Feature Release',
                'content' => 'We are excited to announce the release of our new feature!',
                'author' => 'John Smith',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.833',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 =>
            array (
                'news_id' => '2',
                'title' => 'Upcoming Event: Conference',
                'content' => 'Join us for an informative conference on the latest industry trends.',
                'author' => 'Jane Doe',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.833',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 =>
            array (
                'news_id' => '3',
                'title' => 'Important Announcement',
                'content' => 'Please be informed about the upcoming maintenance scheduled for next week.',
                'author' => 'Admin',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.833',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            3 =>
            array (
                'news_id' => '4',
                'title' => 'Student Achievements',
                'content' => 'Congratulations to our students for their outstanding achievements!',
                'author' => 'Marketing Department',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.833',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));


    }
}
