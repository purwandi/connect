<?php

namespace App\Providers;

use App\ServiceBindings;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class ConnectServiceProvider extends ServiceProvider 
{
    use ServiceBindings;
    
    public function boot()
    {

    }

    public function register()
    {
        $this->registerServices();
    }

    /**
     * Register Connect's services in the container.
     *
     * @return void
     */
    protected function registerServices()
    {
        foreach ($this->bindings as $key => $value) {
            is_numeric($key)
                    ? $this->app->singleton($value)
                    : $this->app->singleton($key, $value);
        }
    }
}