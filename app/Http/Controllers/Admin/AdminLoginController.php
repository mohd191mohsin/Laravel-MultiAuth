<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function index(){
        return view("admin.auth.login");
    }
    public function login(Request $request){
        $request->validate([
            "email"=> "email|required",
            "password"=> "required"
        ]);
        // dd($request->all());
        if(Auth::attempt($request->only(["email","password"]))){
            if(auth()->check() && auth()->user()->is_admin ){
                return redirect()->route("admin.home");
            }
            Auth::logout();
        }
        return back()->withErrors(["email"=> "Wrong Credentials!!!"]);
    }
}
