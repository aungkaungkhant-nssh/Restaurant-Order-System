<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminChefsController;
use App\Http\Controllers\Admin\AdminDishesController;
use App\Http\Controllers\Admin\AdminTablesController;
use App\Http\Controllers\Admin\AdminWaitersController;
use App\Http\Controllers\Admin\AdminCategoriesController;

Route::prefix("/admins")->middleware(["auth:admin"])->name("admins.")->group(function(){
    Route::get('/',[AdminUserController::class,"index"]);
    Route::resource('categories',AdminCategoriesController::class);
    Route::get('/categories/datable/ssd',[AdminCategoriesController::class,"ssd"]);

    Route::resource('chef',AdminChefsController::class);
    Route::get('/chef/datable/ssd',[AdminChefsController::class,"ssd"]);

    Route::resource('dishes',AdminDishesController::class);
    Route::get('/dishes/datable/ssd',[AdminDishesController::class,"ssd"]);

    Route::resource('tables',AdminTablesController::class);
    Route::get('/tables/datable/ssd',[AdminTablesController::class,"ssd"]);

    Route::post('/logout',[LoginController::class,"logout"]);
});