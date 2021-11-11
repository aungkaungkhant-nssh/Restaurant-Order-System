<?php

namespace App\Http\Middleware;

use App\Models\OrderLists;
use Closure;
use Illuminate\Http\Request;

class HasOrderList
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
       $order_lists=OrderLists::all();
       if(count($order_lists)==0){
            return redirect("/");
       }
        return $next($request);
    }
}
