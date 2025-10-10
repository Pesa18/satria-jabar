<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Permission;
use App\Models\Role;
use App\Notifications\Channels\WhatsAppChannel;
use App\Observers\UserObserver;
use BezhanSalleh\FilamentShield\Facades\FilamentShield as FacadesFilamentShield;
use BezhanSalleh\FilamentShield\FilamentShield;
use Filament\Resources\Resource;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Gate;
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
            // app(\Spatie\Permission\PermissionRegistrar::class)
            //     ->setPermissionClass(Permission::class)
            //     ->setRoleClass(Role::class);
        ;
        User::observe(UserObserver::class);
        $this->app->make(ChannelManager::class)->extend('whatsapp', function ($app) {
            return new WhatsAppChannel();
        });

        Gate::before(function (User $user, string $ability) {

            if ($user->hasRole('super_admin')) {
                return true;
            }
        });
    }
}
