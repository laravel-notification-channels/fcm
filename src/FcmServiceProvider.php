<?php

namespace NotificationChannels\Fcm;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class FcmServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(FcmChannel::class)
            ->needs(Client::class)
            ->give(function () {
                return new Client([
                    'base_uri' => config('broadcasting.connections.fcm.url', FcmChannel::DEFAULT_API_URL),
                ]);
            });
    }
}
