<?php

namespace App\Http\Controllers\Chef;

use DataTables;
use Carbon\Carbon;
use App\Models\Dish;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChefDishesController extends Controller
{
    public function index(){
        return view("chef.dishes.index");
    }
    public function ssd(){
        $dishes=Dish::with("category")->select("dishes.*");
        return Datatables::eloquent($dishes)
       
        ->addColumn("category",function($dish){
            if($dish->category){
                return '<p>'.$dish->category->name.'<p>';
            }
        })
        ->editColumn("image",function($dish){
            return '<img class="dishesImage" src='.asset("storage/dishesImage/$dish->image").' />';
        })
        ->editColumn("name",function($dish){
            return Str::ucfirst($dish->name);
        })
        ->editColumn("price",function($dish){
            return $dish->price." ကျပ်";
        })
        ->rawColumns(["image",'category'])
        ->make(true);
    }
}
