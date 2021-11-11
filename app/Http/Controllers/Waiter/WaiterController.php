<?php

namespace App\Http\Controllers\Waiter;

use PDO;
use Exception;
use App\Models\Bill;
use App\Models\Cook;
use App\Models\Dish;
use App\Models\User;
use App\Models\Table;
use App\Models\Detail;
use App\Models\Income;
use App\Models\Category;
use App\Models\OrderCount;
use App\Models\OrderLists;
use App\Helpers\AutoNumber;
use Illuminate\Http\Request;
use Facade\Ignition\Tabs\Tab;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Notification;

class WaiterController extends Controller
{
    public function orders(Request $request){
        $dishes=Dish::with("category");
        if($request->category_id){
          $dishes=$dishes->where("category_id",$request->category_id);
        }
        if($request->foodName){
          $dishes->where('name', 'Like', '%' . $request->foodName . '%');
        }
        $dishes=$dishes->paginate(3);
        $categories=Category::all();
        $tables=Table::whereIn("status",[1])->get();
        
        
        return view("waiter.orders",compact("dishes","categories","tables"));
    }
    public function ssd(){
      $order_lists=OrderLists::all();
      $order_lists=$order_lists->pluck("count")->sum();
      return response()->json([
        "status"=>"success",
        "data"=>$order_lists
      ]);
    }
    public function tables(){
       $tables= Table::all();
       return view("waiter.tables",compact("tables"));
    }
    public function sendNotification(){
      $users=User::all();
      $title="ချက်ပြုတ်ရန်";
      $message="အောက်ပါတို့ကိုချက်ပြုတ်ထားပါ";
      $status=1;
      Notification::send($users,new GeneralNotification($title,$message,$status));
    }
    public function orderListCount(){
      $order_lists_count=OrderLists::all();
      $order_lists_count=$order_lists_count->pluck("count")->sum();
      return $order_lists_count;
    }
    public function orderLists(Request $request){
         $table_number=$request->table_number;
         
         $dish_id=$request->dish_id;
         $request->validate([
            "table_number"=>"required",
            "dish_id"=>"required"
         ]);
         $order_lists=OrderLists::where("table_number",$table_number)->where("dish_id",$dish_id)->first();
         if($table_number){
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
                return response()->json([
                  "status"=>"success",
                  "order_lists_count"=>$order_lists_count
                ]);
              }
              $order_lists->increment("count");
              $order_lists_count=$this->orderListCount();
              $this->sendNotification();
              return response()->json([
                "status"=>"success",
                "order_lists_count"=>$order_lists_count
              ]);
          }
          return response()->json([
            "status"=>"fail"
          ]);
         }
         return response()->json([
           "status"=>"fail"
         ]);
    }
    public function orderListsConfirm(){
      $order_lists=OrderLists::all();
     $table_number=$order_lists->pluck("table_number")->unique()->implode("");
      return view("waiter.orderlistsconfirm",compact("order_lists","table_number"));
    }
    public function orderListIncrease(Request $request){
        $increase_order_id=$request->increase_order_id;
       $data=OrderLists::findOrFail($increase_order_id)->increment("count");
       return "success";
    }
    public function orderListDecrease(Request $request){
      $decrease_order_id=$request->decrease_order_id;
     $data=OrderLists::findOrFail($decrease_order_id)->decrement("count");
     return "success";
    }
   public function orderListDelete(Request $request){
         $delete_order_id=$request->delete_order_id;
         $data=OrderLists::findOrFail($delete_order_id)->delete();
         return "success";
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
        return redirect("/")->with(["success"=>"ပေးပို့ခြင်းအောင်မြင်သည်"]);
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
      return view("waiter.details",compact("details_notifications"));
   }
   public function bill(){
     $tables=Table::all();
     $bills=Bill::all();
     $table_numbers=[];
     foreach($tables as $table){
      $data= Bill::where("table_number",$table->number)->first();
      if($data){
        array_push($table_numbers,$data->table_number);
      }
    
     }
     return view("waiter.bill",compact("table_numbers","bills"));
   }
   public function billClear(Request $request){
        $request->validate([
          "table_number"=>"required",
          "total"=>"required"
        ]);
        DB::beginTransaction();
        try{
          $table=Table::where("number",$request->table_number)->first();
          $table->status=1;
          $table->update();
           Bill::where("table_number",$request->table_number)->delete();
   
           Income::create([
             "table_number"=>$request->table_number,
             "amount"=>$request->total,
           ]);
           DB::commit();
           return redirect()->back()->with(["success"=>"ပိုက်ဆံရှင်းခြင်းအောင်မြင်သည်"]);
        }catch(Exception $e){
          DB::rollBack();
          return back()->withErrors(['fail',$e->getMessage()]);
        }
      
   }
}
