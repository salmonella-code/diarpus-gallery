<?php

namespace App\Providers;

use App\Models\ActiveVillage;
use App\Models\Field;
use App\Models\Village;
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
    public function boot()
    {
        View::composer('layouts.partials.navbar', function($view)
        {
            $fields = Field::all();
            $villages = ActiveVillage::all();
            $view->with('fields', $fields)->with('villages', $villages);
        });
    }
}
