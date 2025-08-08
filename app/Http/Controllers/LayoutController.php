<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;
use App\Models\Blog;
use App\Models\Customer;
use App\Models\PaymentMethod;

class LayoutController extends Controller
{

    public function index(){
        $products = Product::where('disable',0)->orderBy('id','desc')->limit(8)->get();
        $reviews = Review::orderBy('id','desc')->limit(20)->get();
        $blogs = Blog::orderBy('id','desc')->limit(6)->get();

        return view('index',[
            'page_title'=>'Home',
            'products'=>$products,
            'reviews'=>$reviews,
            'blogs'=>$blogs,
        ]);
    }

    public function cart(){
        $products = Product::where('disable',0)->get();
        return view('cart',[
            'page_title'=>'Cart',
            'products'=>$products,
        ]);
    }

    public function buy(){
        $products = Product::where('disable',0)->get();
        return view('buy',[
            'page_title'=>'Order Now',
            'products'=>$products,
        ]);
    }

    public function buyNow(){
        $products = Product::where('disable',0)->get();
        return view('buy-now',[
            'page_title'=>'Order Now',
            'products'=>$products,
        ]);
    }

    public function trade(Request $req){

        /*
        status 0 for initial state
        status 1 for result not found
        status 2 for result found
        */

        $status = 0;
        $customer = null;
        if(isset($req->phone)){
            $status = 1;
            $phone = $req->phone;
            $customer = Customer::where('phone',$phone)->where('collaborate',1)->first();
            if($customer){
                $status = 2;
            }
        }

        $products = Product::where('disable',0)->get();

        return view('trade',[
            'page_title'=>'Collaboration',
            'status'=>$status,
            'customer'=>$customer,
            'products'=>$products,
        ]);

        
    }


    public function collaborate(){
        return view('collaborate',[
            'page_title'=>'Collaboration',
        ]);
    }
}
