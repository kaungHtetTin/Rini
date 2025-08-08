<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AccessLevel;
use App\Models\Admin;

class AdminController extends Controller
{
    public function index(){

        $admins = User::all();

        return view('admin.admins',[
            'page_title' =>'Admins',
            'admins'=>$admins,
        ]);
    }

    public function add(){
        $access_levels = AccessLevel::all();

        return view('admin.admins-add',[
            'page_title' =>'Admins',
            'access_levels'=>$access_levels,
        ]);
    }

    public function store(Request $req){

        $req->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
        ]);

        $user = new User();
        $user->name = $req->name;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->save();

        $access_levels = AccessLevel::all();
        foreach($access_levels as $access){
            $id = $access->id;
            $key = "access_$id";
            if(isset($req->$key)){
                if($req->$key == 'on'){
                   $admin = new Admin();
                   $admin->user_id = $user->id;
                   $admin->access_level_id = $id;
                   $admin->save();
                }
            }
        }

        return back()->with('msg','The new admin was successfully added');
    }

    public function edit($id){
        $user = User::find($id);
        if(!$user) return redirect()->route('admin.404');
        $access_levels = AccessLevel::all();
        return view('admin.admins-edit',[
            'page_title' => 'Edit',
            'access_levels'=>$access_levels,
            'admin' => $user,
        ]);
    }

    public function modify(Request $req, $id){
        $req->validate([
            'name'=>'required',
        ]);

        $user = User::find($id);
        if(!$user) return redirect()->route('admin.404');

        if(isset($req->password)){
            $user->password = Hash::make($req->password);
            $user->save();
        }

        $access_levels = AccessLevel::all();
        foreach($access_levels as $access){
            $id = $access->id;
            $key = "access_$id";
            if(isset($req->$key)){
                if($req->$key == 'on'){
                    $admin = Admin::where('user_id',$user->id)->where('access_level_id',$id)->first();
                    if(!$admin){
                        $admin = new Admin();
                        $admin->user_id = $user->id;
                        $admin->access_level_id = $id;
                        $admin->save();
                    }
                }else{
                    Admin::where('user_id',$user->id)->where('access_level_id',$id)->delete();
                }
            }else{
                Admin::where('user_id',$user->id)->where('access_level_id',$id)->delete();
            }
        }

        return back()->with('msg','The admin was successfully updated');
    }

     public function manageStatus(Request $req, $id){
        $req->validate([
            'status'=>'required|numeric',
        ]);

        $user = User::find($id);
        if(!$user) return redirect()->route('admin.404');
        $user->disable = $req->status;
        $user->save();

        if($req->status == 1) return back()->with('msg','The admin was successfully diabled');
        else return back()->with('msg','The admin was successfully activated');

    }
}
