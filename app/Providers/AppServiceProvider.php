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

        View::composer('layouts.partials.fieldNavbar', function($view)
        {
            
            $field = auth()->user()->field->first();
            $view->with('field', $field);
        });

        View::composer('layouts.partials.villageNavbar', function($view)
        {
            
            $village = auth()->user()->village->first();
            $view->with('village', $village);
        });
    }
}
