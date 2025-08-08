<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

use App\Models\Setting;
use App\Models\PaymentMethod;

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
        //
        Paginator::useBootstrap();
        $excludedViews = [
            'admin.components.*',
            'admin.*',
            // Add other views you want to exclude
        ];

        // Using closure based composers...
       View::composer('*', function ($view) use ($excludedViews) {
            foreach ($excludedViews as $pattern) {
                if (Str::is($pattern, $view->getName())) {
                    return;
                }
            }

            $settings = Setting::all();
            $payment_methods = PaymentMethod::all();
            $view->with([
                'settings'=>$settings,
                'payment_methods'=>$payment_methods,
            ]);
        });
    }
}
