<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Dish;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreDishesRequest;
use App\Http\Requests\UpdateDishesRequest;

class AdminDishesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return view("admin.dishes.index");
    }
    public function ssd(){
        $dishes=Dish::with("category")->select("dishes.*");
        return Datatables::eloquent($dishes)
       
        ->addColumn("action",function($dish){
            $delete_icon='<a href="" class="text-danger " id="delete"><i class="fas fa-trash"  data-id='.$dish->id.'></i></a>';
           $edit_icon='<a href="/admins/dishes/'.$dish->id.'/edit" class="text-warning"><i class="fas fa-edit"></i></a>';
           return '<div class="action-icon d-flex justify-content-around">'.$edit_icon .$delete_icon.'<div>';
        })
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
        ->editColumn("created_at",function($dish){
            return Carbon::parse($dish->created_at)->format("Y-m-d H:i:s");
        })
        ->editColumn("updated_at",function($dish){
            return Carbon::parse($dish->updated_at)->format("Y-m-d H:i:s");
        })
        ->editColumn("price",function($dish){
            return $dish->price." $";
        })
        ->rawColumns(["action","image",'category'])
        ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::all();
        return view("admin.dishes.create",compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDishesRequest $request)
    {
        if($request->hasFile("image")){
            $fileNameWithExt=$request->file("image")->getClientOriginalName();
            $filename=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
            $extension=$request->file("image")->getClientOriginalExtension();
            $fileNameToStore=$filename."_".time().".".$extension;
           $request->file('image')->storeAs("public/dishesImage",$fileNameToStore);
        }
        Dish::create([
            "name"=>$request->name,
            "category_id"=>$request->category_id,
            "image"=>$fileNameToStore,
            "price"=>$request->price,
        ]);
        return redirect(route('admins.dishes.index'))->with(["create"=>"Dishes Created Successfully"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Dish $dish)
    {
        $categories=Category::all();
        return view("admin.dishes.edit",compact("dish","categories"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDishesRequest  $request, Dish $dish)
    {
        if($request->hasFile("image")){
            $fileNameWithExt=$request->file("image")->getClientOriginalName();
            $filename=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
            $extension=$request->file("image")->getClientOriginalExtension();
            $fileNameToStore=$filename."_".time().".".$extension;
            $path=$request->file('image')->storeAs("public/dishesImage/",$fileNameToStore);
            //delete orginal file
            Storage::delete('public/dishesImage/'.$dish->image);
            $dish->image=$fileNameToStore;
        }
        $dish->name=$request->name;
        $dish->category_id=$request->category_id;
        $dish->price=$request->price;
        $dish->update();
        return redirect(route('admins.dishes.index'))->with(["update"=>"Dish update successfully!"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dish $dish)
    {
        $dish->delete();
        return "success";
    }
}


