<?php

namespace App\Providers;

use App\Interfaces\SystemNotifications;
use App\Services\SystemNotifications\MessageQueue;
use Illuminate\Support\ServiceProvider;

class SystemNotificationsProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            SystemNotifications::class,
            MessageQueue::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
