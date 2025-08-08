<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductController extends Controller
{
    public function index(Request $req){

        if(isset($req->category_id)){
            $category_id = $req->category_id;
            $products = Product::where('disable',0)->where('product_category_id',$category_id)->get();
        }else{
            $products = Product::where('disable',0)->get();
            $category_id = 0;
        }

        return view('products',[
            'page_title' => 'Shop',
            'products'=>$products,
            'categories' => ProductCategory::all(),
            'category_id'=>$category_id,
        ]);
    }

    public function show($id){
        $product = Product::find($id);
        if(!$product) return redirect()->route('404');

        $product->view = $product->view + 1;
        $product->save();

        return view('products-show',[
            'page_title'=>'Detail',
            'product'=>$product,
        ]);
    }

    public function buy($id){
        $product = Product::find($id);
        if(!$product) return redirect()->route('404');

        return view('products-buy',[
            'page_title'=>'Buy Now',
            'product'=>$product,
        ]);
    }

}
