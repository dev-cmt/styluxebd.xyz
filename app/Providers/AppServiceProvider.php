<?php

namespace App\Providers;

use App\ConversionApi;
use App\Observers\OrderAssignObserver;
use App\Observers\OrderNoteObserver;
use App\Observers\OrderObserver;
use App\Observers\OrderProductObserver;
use App\Order;
use App\OrderAssign;
use App\OrderNote;
use App\OrderProduct;
use App\PageSetting;
use App\WebSettings;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
    // public function boot()
    // {
    //     View::composer('*', function ($view) {
    //         $view->with('web_settings', WebSettings::with('get_header')->first());
    //         $view->with('page_settings', PageSetting::first());
    //         $view->with('conversion', ConversionApi::first());
    //     });

    //     // View::share('themes', $this->currentTheme());
    // }

    public function boot()
    {
        // View::share('web_settings', cache()->rememberForever('web_settings', function () {
        //     return WebSettings::with('get_header', 'get_favicon', 'get_footer')->first();
        // }));
        View::composer('*', function ($view) {
            $web_settings = cache()->rememberForever('web_settings', function () {
                return WebSettings::with([
                    'get_header',
                    'get_footer',
                    'get_favicon'
                ])->first();
            });
            $conversion_api = cache()->rememberForever('conversion_api', function () {
                return ConversionApi::first();
            });
            $view->with('web_settings', $web_settings);
            $view->with('conversion', $conversion_api);
        });

        View::share('page_settings', cache()->rememberForever('page_settings', function () {
            return PageSetting::first();
        }));


        Order::observe(OrderObserver::class);
        OrderProduct::observe(OrderProductObserver::class);
        OrderAssign::observe(OrderAssignObserver::class);
        OrderNote::observe(OrderNoteObserver::class);
    }

    // public function currentTheme()
    // {
    //     return Theme::where('is_active', 1)->first();
    // }
}
