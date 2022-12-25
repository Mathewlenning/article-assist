<?php

namespace App\Providers;

use App\Services\Mvsc\Contracts\SystemNotifications;
use App\Services\Mvsc\SystemNotifications\MessageQueue;
use Illuminate\Support\ServiceProvider;

class MvscServiceProvider extends ServiceProvider
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
}
