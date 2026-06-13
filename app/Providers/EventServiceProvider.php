<?php

namespace App\Providers;


// FOR CORE EVENTS & LISTENERS

use App\Events\AssessmentPassed;

use App\Listeners\HandleAssessmentPassed;

// FOR MAIL NOTIFICATIONS

use App\Email\Events\CourseEnrollmentCreated;
use App\Email\Events\VideoSessionScheduled;

use App\Email\Listeners\ScheduleVideoSessionReminder;
use App\Email\Listeners\SendCourseEnrollmentNotification;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [

        // Core events and listeners
        AssessmentPassed::class => [
            HandleAssessmentPassed::class,
        ],

        \App\Events\VideoSessionReminderTriggered::class => [
            \App\Listeners\SendVideoSessionReminderEmail::class,
        ],
        

        // Keep student emails limited to enrollment and session reminders.
        CourseEnrollmentCreated::class => [
            SendCourseEnrollmentNotification::class,
        ],

        VideoSessionScheduled::class => [
            ScheduleVideoSessionReminder::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}
