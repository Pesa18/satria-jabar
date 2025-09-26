<?php

namespace App\Providers;

use App\Models\User;
use App\Notifications\Channels\WhatsAppChannel;
use App\Observers\UserObserver;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        $this->app->make(ChannelManager::class)->extend('whatsapp', function ($app) {
            return new WhatsAppChannel();
        });
    }
}
