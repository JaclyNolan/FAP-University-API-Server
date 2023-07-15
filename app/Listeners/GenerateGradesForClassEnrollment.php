<?php

namespace App\Listeners;

use App\Events\ClassEnrollmentCreated;
use App\Models\Grade;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GenerateGradesForClassEnrollment
{
    /**
     * Handle the event.
     */
    public function handle(ClassEnrollmentCreated $event): void
    {
        $classEnrollment = $event->classEnrollment;
        $score = null;
        switch (rand(1, 5)) {
            case 1:
                $score = 50;
                break;
            case 2:
                $score = 60;
                break;
            case 3:
                $score = 80;
                break;
            case 4:
                $score = 100;
                break;
            default:
                $score = null;
        }
        Grade::create([
            'class_enrollment_id' => $classEnrollment->class_course_id,
            'score' => $score,
            'created_at' => Carbon::now(),
            'updated_at' => NULL,
        ]);
    }
}
