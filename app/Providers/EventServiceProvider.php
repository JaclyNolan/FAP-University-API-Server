<?php

namespace App\Providers;

use App\Events\ClassEnrollmentCreated;
use App\Events\ClassScheduleCreated;
use App\Events\StudentCreated;
use App\Listeners\GenerateEnrollmentsForStudent;
use App\Listeners\GenerateGradesForClassEnrollment;
use App\Listeners\HandleClassScheduleReached;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        StudentCreated::class => [
            GenerateEnrollmentsForStudent::class,
        ],
        ClassEnrollmentCreated::class => [
            GenerateGradesForClassEnrollment::class,
        ],
        ClassScheduleCreated::class => [
            HandleClassScheduleReached::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
