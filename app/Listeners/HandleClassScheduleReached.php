<?php

namespace App\Listeners;

use App\Events\ClassScheduleCreated;
use App\Jobs\CloseClassSchedule;
use App\Jobs\EndClassSchedule;
use App\Jobs\GenerateAttendancesForClassSchedule;
use App\Jobs\OpenClassSchedule;
use App\Models\Attendance;
use App\Models\ClassSchedule;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleClassScheduleReached
{
    /**
     * Handle the event.
     *
     * @param  ClassScheduleCreated  $event
     * @return void
     */
    public function handle(ClassScheduleCreated $event)
    {
        $now = Carbon::now();
        $classSchedule = $event->classSchedule;
        $classStartTime = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $classSchedule->day . " " . ClassSchedule::findSlotTime($classSchedule->slot)['start_time']
        );
        $classEndTime = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $classSchedule->day . " " . ClassSchedule::findSlotTime($classSchedule->slot)['end_time']
        );

        $this->generateAttendancesForClassSchedule($event->classSchedule);

        //If schedule is in the past
        if ($classEndTime->isPast()) {
            $event->classSchedule->status = 4;
            $event->classSchedule->save();
            return;
        }
        $classTakeAttendanceTime = $classStartTime->addMinutes(ClassSchedule::getTimeForTakeAttendance());

        //If schedule take attendance time is in the past then close the ability to take attendance
        if ($classTakeAttendanceTime->isPast()) {
            $event->classSchedule->status = 3;
            $event->classSchedule->save();
            $delayEnd = $now->diffInSeconds($classEndTime);
            // dump($delayEnd);
            EndClassSchedule::dispatch($event->classSchedule)->delay($delayEnd);
            return;
        }


        //If schedule is just started and there is still time to take attendance
        if ($classStartTime->isPast()) {
            $event->classSchedule->status = 2;
            $event->classSchedule->save();
            $delayClose = $now->diffInSeconds($classTakeAttendanceTime);
            $delayEnd = $now->diffInSeconds($classEndTime);
            // dump($delayClose, $delayEnd);
            CloseClassSchedule::dispatch($event->classSchedule)->delay($delayClose);
            EndClassSchedule::dispatch($event->classSchedule)->delay($delayEnd);
            return;
        }

        //If schedule is not yet here
        $event->classSchedule->status = 1;
        $event->classSchedule->save();
        $delayOpen = $now->diffInSeconds($classStartTime);
        $delayClose = $now->diffInSeconds($classTakeAttendanceTime);
        $delayEnd = $now->diffInSeconds($classEndTime);
        // dump($delayOpen, $delayClose, $delayEnd);
        OpenClassSchedule::dispatch($event->classSchedule)->delay($delayOpen);
        CloseClassSchedule::dispatch($event->classSchedule)->delay($delayClose);
        EndClassSchedule::dispatch($event->classSchedule)->delay($delayEnd);
    }

    protected function generateAttendancesForClassSchedule($classSchedule)
    {
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
