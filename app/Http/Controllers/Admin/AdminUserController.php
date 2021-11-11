<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Dish;
use App\Models\Income;
use App\Models\Table;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(){
        $allincomes=Income::all();
        $dailyincomes=Income::whereDate("created_at", Carbon::today())->get();
       
       $allTotal=$allincomes->pluck("amount")->reduce(function($carry,$item){
          return  $carry+$item;
        });
        $dailyTotal=$dailyincomes->pluck("amount")->reduce(function($carry,$item){
            return  $carry+$item;
        });
       $tableTotal=Table::all()->count();
       $waiterTotal=User::all()->count();
       $categoriesTotal=Category::all()->count();
       $dishesTotal=Dish::all()->count();
        return view("admin.index",compact("allTotal","dailyTotal","tableTotal","waiterTotal","categoriesTotal","dishesTotal"));
    }
    
}
