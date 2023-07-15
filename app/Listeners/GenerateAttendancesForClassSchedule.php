<?php

namespace App\Listeners;

use App\Events\ClassScheduleCreated;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GenerateAttendancesForClassSchedule
{
    /**
     * Handle the event.
     */
    public function handle(ClassScheduleCreated $event): void
    {
        $classSchedule = $event->classSchedule;
        $classEnrollments = $classSchedule->classCourse->classEnrollments;

        foreach ($classEnrollments as $classEnrollmentData) {
            Attendance::create([
                'class_schedule_id' => $classSchedule->class_schedule_id,
                'class_enrollment_id' => $classEnrollmentData->class_enrollment_id,
                'attendance_status' => false,
                'attendance_time' => null,
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ]);
        }
    }
}
