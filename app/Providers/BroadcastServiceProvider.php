<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes(["prefix" => "api", "middleware" => "auth:api"]); //is for the api clients requests(React Native App in my case)
        // Broadcast::routes();//is for the web requests
        
        require base_path('routes/channels.php');
    }
}
