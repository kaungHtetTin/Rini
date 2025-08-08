<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Product;

class ProductCategoryController extends Controller
{
    public function index(){
        $categories = ProductCategory::all();
        return view('admin.product-categories',[
            'page_title' => 'Product Setting',
            'categories'=> $categories,
        ]);
    }

    public function store(Request $req){
        $req->validate([
            'category'=>'required',
        ]);

        $category = new ProductCategory();
        $category->category = $req->category;
        $category->disable = 0;
        $category->save();

        return back()->with('msg','New category was successfully added');
    }

    public function modify(Request $req, $id){
        $req->validate([
            'category' => 'required',
        ]);
        $category = ProductCategory::find($id);
        $category->category = $req->category;
        $category->save();
        return back()->with('msg','The category was successfully updated');
    }

    public function manageStatus(Request $req, $id){
    
        $req->validate([
            'status'=>'required|numeric',
        ]);
        $status = $req->status;
        $category = ProductCategory::find($id);
        $category->disable = $status;
        $category->save();
        Product::where('product_category_id',$id)->update(['disable'=>$status]);
        if($status == 0) return back()->with('msg','The category and related products were successfully activated');
        else return back()->with('msg','The category and related products were successfully disabled');
    }
}
