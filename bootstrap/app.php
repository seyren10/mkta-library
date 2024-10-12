<?php

use App\Http\Middleware\EnsureThatUserIsAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();

        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
            'admin' => EnsureThatUserIsAdmin::class
        ]);

        //
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule
            ->command('bc:fetch_all')
            ->daily() //Run the task every day at midnight.
            ->runInBackground()
            ->withoutOverlapping();
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
