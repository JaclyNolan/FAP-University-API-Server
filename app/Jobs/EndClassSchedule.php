<?php

namespace App\Jobs;

use App\Models\ClassSchedule;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EndClassSchedule implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public ClassSchedule $classSchedule)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $classSchedule = $this->classSchedule;
        $classSchedule->status = 4;
        $classSchedule->save();
    }
}
