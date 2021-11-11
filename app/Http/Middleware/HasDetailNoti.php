<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Detail;
use Illuminate\Http\Request;

class HasDetailNoti
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $notifications=0;
        $details= Detail::all();
        foreach($details as $detail){
            $notifications+= $detail->notifications()->count();
        }
        if($notifications <=0){
            return redirect("/");
        }
        return $next($request);
    }
}
