<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\FormFields\EquipmentsFormField;
use TCG\Voyager\Facades\Voyager;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Voyager::addFormField(EquipmentsFormField::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
