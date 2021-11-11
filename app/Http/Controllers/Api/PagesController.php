<?php

namespace App\Http\Controllers\Api;

use Error;
use Exception;
use App\Models\Bill;
use App\Models\Cook;
use App\Models\Dish;
use App\Models\User;
use App\Models\Table;
use App\Models\Detail;
use App\Models\Income;
use App\Models\Category;
use App\Models\OrderLists;
use App\Helpers\AutoNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\BillResource;
use App\Http\Resources\DishResource;
use App\Http\Resources\IndexResource;
use App\Http\Resources\TableResource;
use App\Http\Resources\DetailResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\FreeTableReource;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Notification;

class PagesController extends Controller
{
    public function index(Request $request){
        $dishes=Dish::with("category");
        $categories=Category::all();
        $cat_data=CategoryResource::collection($categories);
        if($request->foodName){
         $dishes->where('name', 'Like', '%' . $request->foodName . '%');
        }
        if($request->category_id){
          $dishes=$dishes->where("category_id",$request->category_id);
        }
        $dish_data= DishResource::collection($dishes->get());
        $tables=FreeTableReource::collection(Table::where("status",1)->get());

        return success("success",[["categories"=>$cat_data,"dishes"=>$dish_data,"tables"=>$tables]]);
    }
    public function tables(){
        $tables=Table::all();
       $data=TableResource::collection($tables);
       return success("success",$data);
    }
    public function bill(){
     $tables=Table::all();
     $table_numbers=[];
     foreach($tables as $table){
      $data= Bill::where("table_number",$table->number)->first();
      if($data){
        array_push($table_numbers,$data->table_number);
      }
     }
     $d=[];
     foreach($table_numbers as $t){
         $bs=Bill::where("table_number",$t)->get();
         $total=0;
         foreach($bs as $b){
            $total+=$b->dish->price;
         }
        array_push($d, [$t=>["bill"=>BillResource::collection($bs),"total"=>number_format($total)."(MMK)"]]);
     };
     return success("success",["table"=>$d]);
    }
    public function billClear(Request $request){
        $request->validate([
            "table_number"=>"required",
            "total"=>"required"
          ]);
          DB::beginTransaction();
          try{
            $table=Table::where("number",$request->table_number)->first();
            if($table){
                $table->status=1;
                $table->update();
                Bill::where("table_number",$request->table_number)->delete();
        
                Income::create([
                "table_number"=>$request->table_number,
                "amount"=>$request->total,
                ]);
                DB::commit();
                return success("success",["billclear"=>"ပိုက်ဆံရှင်းခြင်းအောင်မြင်သည်"]);
            }
            throw new Exception("Something went wrong");
          }catch(Exception $e){
            DB::rollBack();
            return fail($e->getMessage());
          }
    }
    public function details(){
      $details=Detail::orderBy("id","desc")->get();
      $details_notifications=[];
      foreach($details as $detail){
        array_push($details_notifications,$detail->notifications()->first());
        foreach($detail->unreadNotifications as $notification){
          $notification->markAsRead();
        }
      }
     return DetailResource::collection($details_notifications);
      // return success("success",["details_notifications"=>$details_notifications]);
    }
    public function orderLists(Request $request){
      $table_number=$request->table_number;
      $dish_id=$request->dish_id;
     
      $order_lists=OrderLists::where("table_number",$table_number)->where("dish_id",$dish_id)->first();
      if($table_number && $dish_id){
       $table=Table::where("number",$request->table_number)->first();
       $dishes=Dish::find($dish_id);
       if($table->status===1 && $dishes){
           if(!$order_lists){
             OrderLists::create([
               "table_number"=>$table_number,
               "dish_id"=>$dish_id,
               "count"=>1
             ]);
           $order_lists_count=$this->orderListCount();
           $this->sendNotification();
           return success("success",null);
           }
           $order_lists->increment("count");
           $order_lists_count=$this->orderListCount();
           $this->sendNotification();
           return success("success",null);
       }
        return fail("Something went wrong");
      }
      return fail("Something went wrong");
    }
    public function orderListCount(){
      $order_lists_count=OrderLists::all();
      $order_lists_count=$order_lists_count->pluck("count")->sum();
      return $order_lists_count;
    }
    public function sendNotification(){
      $users=User::all();
      $title="ချက်ပြုတ်ရန်";
      $message="အောက်ပါတို့ကိုချက်ပြုတ်ထားပါ";
      $status=1;
      Notification::send($users,new GeneralNotification($title,$message,$status));
    }
    public function orderListIncrease(Request $request){
      $increase_order_id=$request->increase_order_id;
      $data=OrderLists::find($increase_order_id);
      if($data){
        $data->increment("count");
        return success("success",null);
      }
      return fail("Something went Wrong");
    }
    public function orderListDecrease(Request $request){
      $decrease_order_id=$request->decrease_order_id;
      $data=OrderLists::find($decrease_order_id);
      if($data){
        $data->decrement("count");
        return success("success",null);
      }
      return fail("Something went Wrong");
    }
    public function orderListDelete(Request $request){
      $delete_order_id=$request->delete_order_id;
      $data=OrderLists::find($delete_order_id);
      if($data){
          $data->delete();
          return success("success",null);
      }
      return fail("Something went Wrong");
    }
    public function orderListComplete(Request $request){
      $request->validate([
        "table_number"=>"required"
      ]);
      $table_number=$request->table_number;
      $order_lists=OrderLists::where("table_number",$table_number)->get();
      $table=Table::where("number",$table_number)->first();
      $table->status=0;
      $table->update();
      foreach($order_lists as $order_list){
        Cook::create([
              "table_number"=>$table_number,
              "dish_id"=>$order_list->dish_id,
              "count"=>$order_list->count,
              "status"=>1,
              "cooking_id"=>AutoNumber::generate()
        ]);
      }
      OrderLists::where("table_number",$table_number)->delete();
      return success("success",["send"=>"ပေးပို့ခြင်းအောင်မြင်သည်","link"=>"/"]);
    }
}
