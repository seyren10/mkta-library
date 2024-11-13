<?php

namespace App\Providers;

use App\Models\ItemRoutingNote;
use App\Models\WorkCenter;
use App\Policies\ItemRoutingNotePolicy;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Services\BusinessCentral\BusinessCentralApiToken;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url') . "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });


        $this->bindDependencies();
        $this->bindModelRouteParameters();
    }

    private function bindDependencies()
    {
        $this->app->bind(BusinessCentralApiToken::class, function () {
            return new BusinessCentralApiToken(
                config('bc.client_id'),
                config('bc.client_secret'),
                config('bc.token_url'),
                config('bc.scope'),
                config('bc.grant_type')
            );
        });
    }

    private function bindModelRouteParameters()
    {
        Route::bind('work_center', function (string $value) {
            return WorkCenter::query()->where('abbr', $value)->firstOrFail();
        });
    }
}
