<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Using class based composers...
        //View::composer('profile', ProfileComposer::class);

        view()->composer(
            'sections.default._sidenav',
            'App\Http\View\Composers\SidebarComposer'
        );

        // Using closure based composers...
        //View::composer('sections.default._sidenav', function ($view) {
            //$view->with('sidebarData', 'Test Data');
        //});
    }
}
