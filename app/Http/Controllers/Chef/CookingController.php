<?php

namespace App\Http\Controllers\Chef;

use Carbon\Carbon;
use App\Models\Bill;
use App\Models\Cook;
use App\Models\User;
use App\Models\Table;
use App\Models\Detail;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Notification;

class CookingController extends Controller
{
    public function index(){
       $users=User::all();
       foreach($users as $user){
            foreach($user->unreadNotifications as $notification){
                $notification->markAsRead();
            };
       }
       return view("chef.cook.index");
    }
    public function ssd(){
        $cooks=Cook::with("dishes");
        return DataTables::of($cooks)
        ->addColumn("name",function($cook){
            return $cook->dishes->name;
        })
        ->editColumn("accept",function($cook){
             return 
             '<div class="text-center" style="color:red;cursor:pointer;">
                    <i class="fas fa-check-circle fa-lg" style="color:blue;" id="accept" data-id='.$cook->cooking_id.'></i>
             </div>';
        })
       
        ->addColumn("reject",function($cook){
            return 
            '<div class="text-center" style="color:red;cursor:pointer;">
                   <i class="fas fa-times-circle fa-lg"  id="reject" data-id='.$cook->cooking_id.'></i>
            </div>';
        })
        ->addColumn("pending",function($cook){
            return 
            '<div class="text-center"  style="color:red;cursor:pointer;">
               <i class="fas fa-spinner fa-lg" style="color:orange;"  id="pending" data-id='.$cook->cooking_id.'></i>
            </div>';
        })
        ->addColumn("ready",function($cook){
            return 
            '<div class="text-center" style="color:red;cursor:pointer;">
               <i class="fas fa-bell fa-lg" style="color:green;" id="ready" data-id='.$cook->cooking_id.'></i>
            </div>';
        })
        ->editColumn("created_at",function($cook){
            return Carbon::parse($cook->created_at)->format("Y-m-d H:i:s");
        })
        ->rawColumns(["accept","reject","pending","ready","amount"])
        ->make(true);
    }
    public function ready(Request $request){
        $cook=$this->arrp($request->id,"အဆင်သင့်ဖြစ်ပြီ","လာယူပါ",1);
        if($cook){
            Bill::create([
                "table_number"=>$cook->table_number,
                "dish_id"=>$cook->dish_id,
                "count"=>$cook->count
            ]); 
            $cook->delete();
              
            return redirect()->back()->with(["create"=>"လာယူခိုင်းလိုက်သည်"]); 
         }
    }
    public function reject(Request $request){
         $cook=$this->arrp($request->id,"ငြင်းပယ်ခြင်း",$request->message,0);
         if($cook){
            $tables=Cook::where("table_number",$cook->table_number)->get();
            if(count($tables)==1){
                $table=Table::where("number",$cook->table_number)->first();
                $table->status=1;
                $table->update();
            }
            $cook->delete();
            return response()->json([
                "status"=>"success",
                "message"=>"ငြင်းပယ်လိုက်ခြင်းအောင်မြင်သည်"
            ]);
         }
         return redirect()->back();
    }
    public function accept(Request $request){
        $cook=$this->arrp($request->id,"လက်ခံသည်","လက်ခံသည်",1);
         if($cook){
            return response()->json(["status"=>"success"]);
         }
        return redirect()->back();
    }
    public function pending(Request $request){
         $cook=$this->arrp($request->id,"ခနစောင့်ရမည်","ခနစောင့်ရမည်",2);
         if($cook){
            return response()->json(["status"=>"success"]);
         }
        return redirect()->back();
    }
    public function arrp($id,$title,$message,$status){
        $cook=Cook::where("cooking_id",$id)->first();
        if($cook){
            $detail=Detail::create([
                "dish_id"=>$cook->dish_id,
                "message"=>$message
            ]);
            $title=$title;
            $message= "စားပွဲနံပါတ်"."(".$cook->table_number.")".$cook->dishes->name." ".$message;
            $status=$status;
            Notification::send([$detail],new GeneralNotification($title,$message,$status));
            return $cook;
        }

    }
    
}
