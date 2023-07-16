<?php

namespace App\Jobs;

use App\Models\Attendance;
use App\Models\ClassSchedule;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateAttendancesForClassSchedule implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $classSchedule;

    /**
     * Create a new job instance.
     */
    public function __construct(ClassSchedule $classSchedule)
    {
        $this->classSchedule = $classSchedule;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $classSchedule = $this->classSchedule;
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
