<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Api\ChefController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\PagesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/',[PagesController::class,"index"]);
Route::get('/tables',[PagesController::class,"tables"]);
Route::get('/bill',[PagesController::class,"bill"]);
Route::post("/billclear",[PagesController::class,"billClear"]);
Route::get('/details',[PagesController::class,"details"]);
Route::get("orderlists",[PagesController::class,"orderlists"]);
Route::middleware(["hasOrderList"])->group(function(){
        Route::post('/order-list-increase',[PagesController::class,"orderListIncrease"]);
        Route::post('/order-list-decrease',[PagesController::class,"orderListDecrease"]);
        Route::delete('/order-list-delete',[PagesController::class,"orderListDelete"]);
        Route::post('/order-lists-complete',[PagesController::class,"orderListComplete"]);
});
//chefs
Route::post('/chefs/login',[LoginController::class,"login"]);
Route::prefix("/chefs")->middleware('auth:api')->group(function(){
        Route::post('/logout',[LoginController::class,"logout"]);
        Route::get('/',[ChefController::class,"notificationCount"]);
        Route::get('/categories/index',[ChefController::class,"categories"]);
        Route::get('/dishes/index',[ChefController::class,"dishes"]);
        Route::get('/cooks',[ChefController::class,"cooks"]);
        Route::get("/cooks/accept",[ChefController::class,"accept"]);
        Route::get("/cooks/reject",[ChefController::class,"reject"]);
        Route::get("/cooks/pending",[ChefController::class,"pending"]);
        Route::get("/cooks/ready",[ChefController::class,"ready"]);
});
Route::get('/linkstorage', function () {
        Artisan::call('storage:link'); // this will do the command line job
});