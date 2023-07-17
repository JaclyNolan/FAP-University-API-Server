<?php

namespace Database\Seeders;

use App\Models\ClassCourse;
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

        $classCourses = ClassCourse::all();

        foreach ($classCourses as $classCourse) {
            $classCourseId = $classCourse->class_course_id;
            $randomDayOfWeek = Carbon::now()->startOfWeek()->addDays(rand(0, 6));
            $slot = rand(1, 6);
            $room = rand(100, 110);
            ClassSchedule::create([
                'class_course_id' => $classCourseId,
                'day' => $randomDayOfWeek->toDateString(),
                'slot' => $slot,
                'room' => $room,
            ]);
            for ($i = 0; $i < 5; $i++) {
                ClassSchedule::create([
                    'class_course_id' => $classCourseId,
                    'day' => $randomDayOfWeek->subWeeks(1)->toDateString(),
                    'slot' => $slot,
                    'room' => $room,
                ]);
            }
            $randomDayOfWeek->addWeeks(5);
            for ($i = 0; $i < 5; $i++) {
                ClassSchedule::create([
                    'class_course_id' => $classCourseId,
                    'day' => $randomDayOfWeek->addWeeks(1)->toDateString(),
                    'slot' => $slot,
                    'room' => $room,
                ]);
            }
        }
    }
}
