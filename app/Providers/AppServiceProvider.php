<?php

namespace App\Providers;

use App\Models\Detail;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
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
        
        Paginator::useBootstrap();
        View::composer("*",function($view){
            $unread_notifications=0;
            $details= Detail::all();
            foreach($details as $detail){
                $unread_notifications+= $detail->unreadNotifications->count();
            }
            $view->with("unread_notifications",$unread_notifications);
        });
    }
}
