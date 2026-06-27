<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate as FacadesGate;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use App\Models\Page;
use App\Models\User;
use Illuminate\Support\Facades\View;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    public function boot()
    {
        // Map legacy morph classes
        \Illuminate\Database\Eloquent\Relations\Relation::morphMap([
            'App\User' => 'App\Models\User',
        ]);

        // Ensure runtime folders exist (sessions/views/cache) to avoid file_put_contents errors.
        File::ensureDirectoryExists(storage_path('framework/sessions'));
        File::ensureDirectoryExists(storage_path('framework/views'));
        File::ensureDirectoryExists(storage_path('framework/cache/data'));
        File::ensureDirectoryExists(storage_path('logs'));

        $dbHost = env('DB_HOST', env('DB_HOST_LOCAL', '127.0.0.1'));
        $fallbackHost = env('DB_HOST_FALLBACK', 'host.docker.internal');

        if (!filter_var($dbHost, FILTER_VALIDATE_IP)) {
            $resolved = gethostbyname($dbHost);

            if ($resolved === $dbHost || $resolved === false) {
                $resolvedFallback = gethostbyname($fallbackHost);

                if ($resolvedFallback !== $fallbackHost && $resolvedFallback !== false) {
                    Config::set('database.connections.mysql.host', $fallbackHost);
                } else {
                    Config::set('database.connections.mysql.host', env('DB_HOST_LOCAL', '127.0.0.1'));
                }
            }
        }

        View::composer('layouts.client', function ($view) {
            $headerData = Page::where('status', 1)->get();
            $point = User::select('points')->where('id', session('clientUserID'))->first();
            $view->with(['dataHeader' => $headerData, 'point' => $point]);
        });
    }
}
