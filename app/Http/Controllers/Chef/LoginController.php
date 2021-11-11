<?php

namespace App\Http\Controllers\Chef;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware("guest")->except("logout");
    }
    public function showLogin(){
        return view("chef_auth.login");
    }
    public function login(Request $request){
        $request->validate([
            "phone"=>"required",
            "password"=>"required"
        ]);
        if(Auth::guard("web")->attempt([
            "phone"=>$request->phone,
            "password"=>$request->password,
        ])){
            return redirect('/chefs');
        }

        return back()->withErrors(["fails"=>"These phone and password do not match our records"])
       ;
    }
    protected function guard()
    {
        return Auth::guard("web");
    }
    public function logout(){
        $this->guard()->logout();
        return redirect('/chefs/login');
    }
}
