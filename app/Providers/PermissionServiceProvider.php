<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PermissionService;

class PermissionServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Generate permissions saat deployment di production
        if ($this->app->environment('production')) {
            $this->app->booted(function () {
                $permissionService = app(PermissionService::class);
                $permissionService->generatePermissions();
            });
        }
    }
} 