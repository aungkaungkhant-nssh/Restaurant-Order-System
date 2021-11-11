<?php

namespace App\Http\Controllers\Api;

use App\Models\Bill;
use App\Models\Cook;
use App\Models\Dish;
use App\Models\User;
use App\Models\Detail;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CookResource;
use App\Http\Resources\DishResource;
use App\Http\Resources\CategoryResource;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Notification;

class ChefController extends Controller
{
    public function notificationCount(){
        if(auth()->user()){
           $count=auth()->user()->unreadNotifications->count()?auth()->user()->unreadNotifications->count():"0";
           return success("success",["noti_count"=>$count]);
        }
       
    }
    public function categories(){
       $categories=Category::all();
       $data= CategoryResource::collection($categories);
       return success("success",$data);
    }
    public function dishes(){
        $dishes=Dish::all();
        $data=DishResource::collection($dishes);
        return success("success",$data);
    }
    public function cooks(){
        $cooks=Cook::all();
        $users=User::all();
        foreach($users as $user){
                foreach($user->unreadNotifications as $notification){
                    $notification->markAsRead();
                };
        }
        $data= CookResource::collection($cooks);
        return success("success",$data);
    }
    public function accept(Request $request){
        $cook=$this->arrp($request->id,"လက်ခံသည်","လက်ခံသည်",1);
         if($cook){
           return success("success",["accept"=>"အစားသောက်ကိုလက်ခံလိုက်သည်"]);
         }
       return fail("Something went wrong");
    }
    public function reject(Request $request){
        $cook=$this->arrp($request->id,"ငြင်းပယ်ခြင်း",$request->message,0);
        if($cook){
           $cook->delete();
           return success("success",["reject"=>"ငြင်းပယ်လိုက်ခြင်းအောင်မြင်သည်"]);

        }
        return fail("Something went wrong");
   }
   public function pending(Request $request){
    $cook=$this->arrp($request->id,"ခနစောင့်ရမည်","ခနစောင့်ရမည်",2);
    if($cook){
        return success("success",["pending"=>"စောာင့်ခိုင်းလိုက်သည်"]);
    }
    return fail("Something went wrong");
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
            return success("success",["ready"=>"လာယူခိုင်းလိုက်သည်"]); 
         }
        
      
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
