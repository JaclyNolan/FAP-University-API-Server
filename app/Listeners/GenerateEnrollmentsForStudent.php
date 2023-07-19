<?php

namespace App\Listeners;

use App\Events\StudentCreated;
use App\Models\Enrollment;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GenerateEnrollmentsForStudent
{
    /**
     * Handle the event.
     */
    public function handle(StudentCreated $event): void
    {
        $student = $event->student;
        //Get all the courses of the major that student is associated with
        $courses = $student->major->courses;
        //Generate enrollment records for each course
        // dump($student, $student->major ,$courses);
        foreach ($courses as $course) {
            Enrollment::create([
                'student_id' => $student->student_id,
                'course_id' => $course->course_id,
                'status' => rand(1, 7),
                'created_at' => Carbon::now(),
                'updated_at' => NULL,
            ]);
        }

    }
}
