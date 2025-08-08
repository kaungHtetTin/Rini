<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function contact(){
        $settings = Setting::all();
        return view('admin.setting-update-contact',[
            'page_title'=>'Update Contact',
            'settings'=>$settings,
        ]);
    }

    public function update_contact(Request $req){
        $req->validate([
            'address'=>'required',
            'phone'=>'required',
            'email'=>'required',
        ]);

        Setting::where('content','address')->update(['value'=>$req->address]);
        Setting::where('content','phone')->update(['value'=>$req->phone]);
        Setting::where('content','email')->update(['value'=>$req->email]);
        Setting::where('content','facebook')->update(['value'=>$req->facebook]);
        Setting::where('content','youtube')->update(['value'=>$req->youtube]);
        Setting::where('content','instagram')->update(['value'=>$req->instagram]);
        Setting::where('content','tiktok')->update(['value'=>$req->tiktok]);
        
        return back()->with('msg','The contact information are successfully updated');
    }
}
