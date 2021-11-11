<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request){
        $request->validate([
            "phone"=>"required",
            "password"=>"required",
        ]);
        if(Auth::attempt([
            "phone"=>$request->phone,
            "password"=>$request->password,
        ])){
            $user=auth()->user();
            $token=$user->createToken("ro_system")->accessToken;
            return success("Successfully Login",$token);
        }
        return fail("These phone and password do not match our records");
    }
    public function logout(){
        $user=Auth::user();
        $user->token()->revoke();
        return success("Successfully Logout",null);
    }
}
