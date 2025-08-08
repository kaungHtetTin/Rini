<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Product;

class BlogController extends Controller
{
    public function index(){
        $blogs = Blog::orderBy('updated_at','desc')->paginate(20);
        return view('blogs',[
            'page_title'=>'Blogs',
            'blogs'=>$blogs,
        ]);
    }

    public function show($id){
        $blog = Blog::find($id);
        $blogs = Blog::orderBy('id','desc')->limit(10)->get();
        $products = Product::orderBy('id','desc')->limit(10)->get();
        return view('blogs-show',[
            'page_title' => "Detail",
            'blog'=>$blog,
            'blogs'=>$blogs,
            'products'=>$products,
        ]);
    }
}
