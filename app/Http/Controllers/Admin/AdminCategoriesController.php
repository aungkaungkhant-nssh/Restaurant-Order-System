<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoriesRequest;
use App\Http\Requests\UpdateCategoriesRequest;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;
class AdminCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        return view("admin.categories.index");
    }
    public function ssd(){
        $categories=Category::query();
        return Datatables::of($categories)
        ->addColumn("action",function($cat){
            $delete_icon='<a href="" class="text-danger " id="delete"><i class="fas fa-trash"  data-id='.$cat->id.'></i></a>';
           $edit_icon='<a href="/admins/categories/'.$cat->id.'/edit" class="text-warning"><i class="fas fa-edit"></i></a>';
           return '<div class="action-icon d-flex justify-content-around">'.$edit_icon .$delete_icon.'<div>';
        })
     
        ->editColumn("created_at",function($cat){
            return Carbon::parse($cat->created_at)->format("Y-m-d H:i:s");
        })
        ->editColumn("updated_at",function($cat){
            return Carbon::parse($cat->updated_at)->format("Y-m-d H:i:s");
        })
        ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.categories.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoriesRequest $request)
    {
        Category::create($request->validated()+["slug"=>mt_rand()]);
        return redirect(route('admins.categories.index'))->with(["create"=>"Category create successfully!"]);
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
    public function edit(Category $category)
    {
        return view("admin.categories.edit",compact("category"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoriesRequest $request,$id)
    {
        $category=Category::findOrFail($id);
        $category->name=$request->name;
        $category->update();
        // $category->name=$request->name;
        
        // $category->update();
        return redirect(route('admins.categories.index'))->with(["update"=>"Category update successfully!"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return "success";
    }
}
