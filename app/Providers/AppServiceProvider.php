<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;

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
        Schema::defaultStringLength(191);

        view()->composer(['layouts.master', 'layouts.mastershow'], function ($view){
                $theme = \Cookie::get('theme');
                $setting = \App\Models\Setting::where('id', 1)->first();
                if (empty($theme)) {
                    $theme = $setting->theme;
                }
                $view->with('theme', $theme);
        });

        view()->composer('public.archives', function ($view) {
            $view->with('archives', \App\Models\Post::archives());
        });

        view()->composer('public.tags', function ($view) {
            $view->with('tags', \App\Models\Tag::has('posts')->latest()->paginate(30));
        });

        view()->composer('posts.tagselect', function ($view) {
            $view->with('tags', \App\Models\Tag::all());
        });

        view()->composer('layouts.nav', function ($view) {
            $view->with('setting', \App\Models\Setting::where('id', 1)->first());
        });

        view()->composer('auth.login', function ($view) {
            $view->with('setting', \App\Models\Setting::where('id', 1)->first());
        });

        view()->composer('layouts.master', function ($view) {
            $view->with('setting', \App\Models\Setting::where('id', 1)->first());
        });

        view()->composer('public.*', function ($view) {
            $view->with('setting', \App\Models\Setting::where('id', 1)->first());
        });

        view()->composer('public.*', function ($view) {
            $view->with('pages', \App\Models\Page::orderBy('id', 'ASC') ->get());
        });


        Blade::if('modorall', function () {
            $setting = \App\Models\Setting::where('id', 1)->first();
            return auth()->user()->can('moderator-post') OR $setting->allow_users == '0';
        });

        Paginator::useBootstrap();
    }
}
