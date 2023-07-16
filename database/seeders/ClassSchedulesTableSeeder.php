<?php

namespace Database\Seeders;

use App\Models\ClassSchedule;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassSchedulesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('Class_schedules')->delete();

        $classSchedules = [
            [
                'class_course_id' => '1',
                'day' => Carbon::today()->toDateString(),
                'slot' => '6',
                'room' => '101',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.923',
                'updated_at' => NULL,
            ],
            [
                'class_course_id' => '1',
                'day' => '2023-05-18',
                'slot' => '1',
                'room' => '101',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.923',
                'updated_at' => NULL,
            ],
            [
                'class_course_id' => '1',
                'day' => '2023-05-19',
                'slot' => '2',
                'room' => '102',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.923',
                'updated_at' => NULL,
            ],
            [
                'class_course_id' => '2',
                'day' => '2023-05-20',
                'slot' => '3',
                'room' => '103',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.923',
                'updated_at' => NULL,
            ],
            [
                'class_course_id' => '2',
                'day' => '2023-05-21',
                'slot' => '4',
                'room' => '104',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.923',
                'updated_at' => NULL,
            ],
            [
                'class_course_id' => '3',
                'day' => '2023-05-22',
                'slot' => '1',
                'room' => '105',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.923',
                'updated_at' => NULL,
            ],
            [
                'class_course_id' => '3',
                'day' => '2023-05-23',
                'slot' => '2',
                'room' => '106',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.923',
                'updated_at' => NULL,
            ],
            [
                'class_course_id' => '4',
                'day' => '2023-05-24',
                'slot' => '3',
                'room' => '107',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.923',
                'updated_at' => NULL,
            ],
            [
                'class_course_id' => '4',
                'day' => '2023-05-25',
                'slot' => '4',
                'room' => '108',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.923',
                'updated_at' => NULL,
            ],
            [
                'class_course_id' => '5',
                'day' => '2023-05-26',
                'slot' => '1',
                'room' => '109',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.923',
                'updated_at' => NULL,
            ],
            [
                'class_course_id' => '5',
                'day' => '2023-05-27',
                'slot' => '2',
                'room' => '110',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.923',
                'updated_at' => NULL,
            ],
        ];
        // dump($classSchedules);

        foreach ($classSchedules as $classSchedule) {
            ClassSchedule::create($classSchedule);
        }
    }
}
