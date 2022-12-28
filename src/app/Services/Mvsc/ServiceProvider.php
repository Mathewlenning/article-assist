<?php

namespace App\Services\Mvsc;

use App\Services\Mvsc\Contracts\SystemNotifications;
use App\Services\Mvsc\SystemNotifications\MessageQueue;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
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
