<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function uploadImage(Request $req){
        $req->validate([
            'image' => 'required',
        ]);

        if($req->hasFile('image')){
            $image = $req->file('image');
            $path = $image->store('blogs', 'public');
            return response()->json($path, 201);
        }else{
            return ['status'=>'fail'];
        }
    }
}
