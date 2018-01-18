<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Api\Shift\Interfaces\ShiftRepositoryInterface;
use App\Api\Shift\ShiftRepository;

class ShiftServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ShiftRepositoryInterface::class, ShiftRepository::class);
    }
}
