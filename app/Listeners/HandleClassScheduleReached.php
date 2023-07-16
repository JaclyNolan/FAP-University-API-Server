<?php

namespace App\Listeners;

use App\Events\ClassScheduleCreated;
use App\Jobs\GenerateAttendancesForClassSchedule;
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

        if ($classStartTime->isPast()) {
            // If the scheduled time is in the past, dispatch the job immediately
            GenerateAttendancesForClassSchedule::dispatch($event->classSchedule);
        } else {
            // Calculate the delay as the difference between the current time and the 'day' attribute
            $delay = $now->diffInSeconds($classStartTime);
            // dump($classStartTime->toString());
            // Dispatch the job with the calculated delay
            GenerateAttendancesForClassSchedule::dispatch($event->classSchedule)->delay($delay);
        }
    }
}
