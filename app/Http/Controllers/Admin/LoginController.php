<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware("guest:admin")->except("logout");
    }
    public function showLogin(){
        return view("admin_auth.login");   
    }
    public function login(Request $request){
        $request->validate([
            "phone"=>"required",
            "password"=>"required"
        ]);
        if(Auth::guard("admin")->attempt([
            "phone"=>$request->phone,
            "password"=>$request->password,
        ])){
            return redirect('/admins');
        }

        return back()->withErrors(["fails"=>"These phone and password do not match our records"])
       ;
    }
    protected function guard()
    {
        return Auth::guard("admin");
    }
    public function logout(){
        $this->guard()->logout();
        return redirect('/admins/login');
    }
}
