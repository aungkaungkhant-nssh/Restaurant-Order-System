<?php



namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests\StoreChefsRequest;
use App\Http\Requests\UpdateChefsRequest;
use App\Http\Requests\StoreWaitersRequest;
use App\Http\Requests\UpdateWaitersRequest;

class AdminChefsController extends Controller
{
    public function index()
    {  
        return view("admin.chefs.index");
    }
    public function ssd(){
        $users=User::query();
        
        return Datatables::of($users)
        ->addColumn("action",function($user){
            $delete_icon='<a href="" class="text-danger " id="delete"><i class="fas fa-trash"  data-id='.$user->id.'></i></a>';
           $edit_icon='<a href="/admins/chef/'.$user->id.'/edit" class="text-warning"><i class="fas fa-edit"></i></a>';
           return '<div class="action-icon d-flex justify-content-around">'.$edit_icon .$delete_icon.'<div>';
        })
        ->editColumn("created_at",function($user){
            return Carbon::parse($user->created_at)->format("Y-m-d H:i:s");
        })
        ->editColumn("updated_at",function($user){
            return Carbon::parse($user->updated_at)->format("Y-m-d H:i:s");
        })
        ->make(true);
    }
    public function create(){
        return view("admin.chefs.create");
    }
    public function store(StoreChefsRequest $request){
        User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "phone"=>$request->phone,
            "address"=>$request->address,
            "password"=>Hash::make($request->password)
        ]);
        return redirect(route("admins.chef.index"))->with(["create"=>"Chefs Create Successfully!"]);
    }
    public function edit($id){
        $user=User::where("id",$id)->first();
        return view("admin.chefs.edit",compact("user"));
    }
    public function update(UpdateChefsRequest $request,$id){
        $user=User::findOrFail($id);
        $user->name=$request->name;
        $user->email=$request->email;
        $user->phone=$request->phone;
        $user->password=$request->password?Hash::make($request->password):$user->password;
        $user->address=$request->address;
        $user->update();
        return redirect(route('admins.chef.index'))->with(["update"=>"Chefs update successfully!"]);
    }
    public function destroy($id)
    {
        $user=User::findOrFail($id);
        $user->delete();
        return "success";
    }
}

