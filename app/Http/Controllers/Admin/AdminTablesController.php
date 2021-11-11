<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Table;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTablesRequest;

class AdminTablesController extends Controller
{
    public function index(){
        return view("admin.tables.index");
    }
    public function ssd(){
        $tables=Table::query();
        return Datatables::of($tables)
        ->addColumn("action",function($table){
            $delete_icon='<a href="" class="text-danger " id="delete"><i class="fas fa-trash"  data-id='.$table->id.'></i></a>';
           return '<div class="action-icon d-flex justify-content-around">' .$delete_icon.'<div>';
        })
        ->editColumn("status",function($table){
            if($table->status==0){
                return '<span class="badge badge-danger">မအားသေးပါ<span>';
            }
            if($table->status==1){
                return '<span class="badge badge-success">အားပြီ<span>';
            }
            if($table->status==2){
                return '<span class="badge badge-warning">ခနစောင့်ဘာ<span>';
            }
        })
        ->editColumn("created_at",function($cat){
            return \Carbon\Carbon::parse($cat->created_at)->format("Y-m-d H:i:s");
        })
       ->rawColumns(["action","status"])
        ->make(true);
    }
    public function create(){
        return view("admin.tables.create");
    }
    public function store(StoreTablesRequest $request){
       Table::firstOrCreate(
           ["number"=>$request->number],
           [
               "number"=>$request->number,
               "status"=>1
           ]
       );
       return redirect(route('admins.tables.index'))->with(["create"=>"Create Tables Successfully"]);
    }
    public function destroy(Table $table){
        $table->delete();
        return "success";
    }
}
