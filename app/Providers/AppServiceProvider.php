<?php

namespace App\Providers;

use App\Services\AuditLogger;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

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
        Paginator::useBootstrapFive();

        // Journalise automatiquement les connexions et déconnexions.
        Event::listen(Login::class, function (Login $event): void {
            AuditLogger::logForUser($event->user->id, "{$event->user->name} s'est connecté", 'users', $event->user->id);
        });

        Event::listen(Logout::class, function (Logout $event): void {
            if ($event->user) {
                AuditLogger::logForUser($event->user->id, "{$event->user->name} s'est déconnecté", 'users', $event->user->id);
            }
        });
    }
}
