<?php

namespace App\Http\Controllers\Chef;

use Carbon\Carbon;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;

class ChefCategoriesController extends Controller
{
    public function index(){
        return view("chef.categories.index");
    }
    public function ssd(){
        $categories=Category::query();
        
        return Datatables::of($categories)
        ->make(true);
    }
}
