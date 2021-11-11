<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Chef\ChefController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Chef\CookingController;
use App\Http\Controllers\Waiter\WaiterController;
use App\Http\Controllers\Chef\ChefDishesController;
use App\Http\Controllers\Chef\ChefCategoriesController;
use App\Http\Controllers\Chef\LoginController as ChefLoginController;
use App\Http\Controllers\Waiter\LoginController as WaiterLoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[WaiterController::class,"orders"]);
Route::get('/tables',[WaiterController::class,"tables"]);
Route::post('/order-lists',[WaiterController::class,"orderLists"]);
Route::get('/ssd',[WaiterController::class,"ssd"]);
Route::get('/details',[WaiterController::class,"details"])->middleware("hasDetailNoti");
Route::get('/bill',[WaiterController::class,"bill"]);
Route::post("/billclear",[WaiterController::class,"billClear"]);
Route::middleware(["hasOrderList"])->group(function(){
    Route::get("/order-lists-confirm",[WaiterController::class,"orderListsConfirm"]);
    Route::post('/order-list-increase',[WaiterController::class,"orderListIncrease"]);
    Route::post('/order-list-decrease',[WaiterController::class,"orderListDecrease"]);
    Route::delete('/order-list-delete',[WaiterController::class,"orderListDelete"]);
    Route::post('/order-lists-complete',[WaiterController::class,"orderListComplete"]);
});

//admin login
Route::get('/admins/login',[LoginController::class,"showLogin"])->name('admin.login');
Route::post('/admins/login',[LoginController::class,"login"]);

//chef login
Route::get('/chefs/login',[ChefLoginController::class,"showLogin"])->name('chef.login');
Route::post('/chefs/login',[ChefLoginController::class,"login"]);

Route::prefix("/chefs")->middleware(["auth"])->name("chefs.")->group(function(){
 

    Route::get('/',[ChefController::class,"index"]);
    
    Route::get("/cooks",[CookingController::class,"index"]);
    Route::get("/cooks/datable/ssd",[CookingController::class,"ssd"]);
    
    Route::get("/cooks/reject",[CookingController::class,"reject"]);
    Route::get("/cooks/accept",[CookingController::class,"accept"]);
    Route::get('/cooks/pending',[CookingController::class,"pending"]);
    Route::get('/cooks/ready',[CookingController::class,"ready"]);

    Route::get('/categories/index',[ChefCategoriesController::class,'index'])->name('categories.index');
    Route::get('/categories/datable/ssd',[ChefCategoriesController::class,'ssd']);

    Route::get("/dishes/index",[ChefDishesController::class,"index"])->name("dishes.index");
    Route::get('/dishes/datable/ssd',[ChefDishesController::class,'ssd']);



    Route::post('/logout',[ChefLoginController::class,"logout"]);
});
Route::get('/linkstorage', function () {
    Artisan::call('storage:link'); // this will do the command line job
});
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
