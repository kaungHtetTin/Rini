<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;


class ProductController extends Controller
{
    public function uploadImage(Request $req, $id){
        $req->validate([
            'image' => 'required',
        ]);

        if($req->hasFile('image')){
            $image = $req->file('image');
            $path = $image->store('images', 'public');
            $product_image = new ProductImage();
            $product_image->product_id = $id;
            $product_image->image_url = $path;
            $product_image->save();

            return ['status'=>'success'];
        }else{
            return ['status'=>'fail'];
        }
    }
}
