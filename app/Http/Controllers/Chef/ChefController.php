<?php

namespace App\Http\Controllers\Chef;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChefController extends Controller
{
    public function index(){
        return view("chef.dashboard.index");
    }
}
