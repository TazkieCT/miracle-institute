<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'set.active.role' => \App\Http\Middleware\SetActiveRole::class,
            'role' => \App\Http\Middleware\EnsureRole::class,
            'course.enrolled' => \App\Http\Middleware\EnsureCourseEnrollment::class,
            'topic.access' => \App\Http\Middleware\EnsureTopicAccess::class,
            'assessment.access' => \App\Http\Middleware\EnsureAssessmentAccess::class,
            'attendance.window' => \App\Http\Middleware\EnsureAttendanceWindow::class,
            'permission' => \App\Http\Middleware\CheckPermission::class,
            'role.redirect' => \App\Http\Middleware\RedirectIfRoleMismatch::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
