<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use OpenAI\Client;

class OpenAiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Client::class, function () {
            return \OpenAI::client(config('services.open_ai.key'));
        });
    }
}
