<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Hash;

class AuthController extends Controller
{
    public function login(Request $req){
        $req->validate([
            'email' => 'required',
            'password'=> 'required',
        ]);
        $admin = Admin::where('email',$req->email)->first();
        if($admin){
            if(Hash::check($req->password, $admin->password)){
                
            }
        }
        
        return back()->with('error',"Email and password does not match");
    }
   

}
