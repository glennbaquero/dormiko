<?php

namespace App\Providers;

use App\Building;
use App\PageItem;
use App\Helpers\RouteChecker;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        View::composer('*', function ($view) {
            $view->with('carbon', new Carbon);

            $words = explode(' ', config('app.name'));
            $acronym = "";

            foreach ($words as $w) {
              $acronym .= $w[0];
            }

            $view->with('headerAcronym', $acronym);

            /* Get route */
            if($route = \Request::route()) {

                /* Add in the public vars */
                View::share('route', $route->getName());
                View::share('checker', new RouteChecker($route));
            }

            /* Buildings */
            $available_buildings = Building::Available()->get();
            $comingsoon_buildings = Building::ComingSoon()->get();
            $all_buildings = Building::all();

            View::composer('includes.footer',  function($view) {
                $logo = PageItem::where('slug', 'logo')->first()->content;
                $email = PageItem::where('slug', 'email')->first()->content;
                $fb_link = PageItem::where('slug', 'fb_link')->first()->content;
                $instagram_link = PageItem::where('slug', 'instagram_link')->first()->content;
                $main_address = PageItem::where('slug', 'main_address')->first()->content;
                $phone_number_one = PageItem::where('slug', 'phone_number_one')->first()->content;
                $phone_number_two = PageItem::where('slug', 'phone_number_two')->first()->content;
                $view->with('footerLogo', $logo);
                $view->with('email', $email);
                $view->with('fb_link', $fb_link);
                $view->with('instagram_link', $instagram_link);
                $view->with('main_address', $main_address);
                $view->with('phone_number_one', $phone_number_one);
                $view->with('phone_number_two', $phone_number_two);
            });

            $view->with('available_buildings', $available_buildings);
            $view->with('comingsoon_buildings', $comingsoon_buildings);
            $view->with('all_buildings', $all_buildings);

        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
