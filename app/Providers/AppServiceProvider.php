<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Str;
use Dedoc\Scramble\Scramble;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        /**
         * 1. KONFIGURASI RUTE API
         */
        Scramble::configure()
            ->routes(function (Route $route) {
                return Str::startsWith($route->uri, 'api/');
            });

        /**
         * 2. SECURITY SCHEME
         */
        Scramble::afterOpenApiGenerated(function (OpenApi $openApi) {
            $openApi->secure(
                SecurityScheme::http('bearer')
            );
        });

        /**
         * 3. GATE IZIN DOKUMENTASI API
         */
        Gate::define('viewApiDocs', function () {
            return true;
        });

        /**
         * 4. GATE MANAGE PRODUCT (WEB)
         */
        Gate::define('manage-product', function (User $user) {
            return $user->role === 'admin';
        });

        /**
         * 5. GATE MANAGE CATEGORY (WEB)
         */
        Gate::define('manage-category', function (User $user) {
            return $user->role === 'admin';
        });
    }
}