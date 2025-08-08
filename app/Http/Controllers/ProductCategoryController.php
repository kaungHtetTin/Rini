<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    public function index(){
        $categories = ProductCategory::all();
        return view('admin.product-categories',[
            'page_title' => 'Product Setting',
            'categories'=> $categories,
        ]);
    }
}
