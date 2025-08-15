<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\ProductImage;

class ProductController extends Controller
{
    public function index(){
        $products = Product::orderBy('disable','asc')->orderBy('id','desc')->paginate(100);
        return view('admin.products',[
            'page_title' => 'Products',
            'products' => $products,
        ]);
    }

    public function add(){
        $categories = ProductCategory::where('disable',0)->get();
        return view('admin.products-add',[
            'page_title' => 'Product Setting',
            'categories'=> $categories,
        ]);
    }

    public function store(Request $req){
        $req->validate([
            'image'=>'required',
            'title'=>'required',
            'description'=>'required',
            'category_id'=>'required',
        ]);

        $instock = $req->instock == 'on' ? 1 : 0;

        if($req->hasFile('image')){
            $image = $req->file('image');
            $path = $image->store('images', 'public');
            
            $product = new Product();
            $product->product_category_id = $req->category_id;
            $product->title = $req->title;
            $product->description = $req->description;
            $product->image_url = $path;
            $product->order_count = 0;
            $product->instock = $instock;
            $product->disable = 0;
            $product->view = 0;
            $product->save();
            
            return redirect("admin/products/".$product->id."/prices");
            
           // return back()->with('msg', 'New product was successfully addeds');
        }

        return back()->with('error', 'Job Fail! An expected error.');

    }

    public function edit($id){
        $product = Product::find($id);
        
        if(!$product) return redirect()->route('admin.404');
        $categories = ProductCategory::where('disable',0)->get();
        $images = ProductImage::where('product_id',$id)->get();
        return view('admin.products-edit',[
            'page_title' => 'Products',
            'product'=>$product,
            'categories'=> $categories,
            'images'=>$images,
        ]);
    }

    public function modify(Request $req,$id){
        $product = Product::find($id);
        if(!$product) return redirect()->route('admin.404');
        $req->validate([
            'title'=>'required',
            'description'=>'required',
            'category_id'=>'required',
        ]);

        $image_url = $product->image_url;
        $instock = $req->instock == 'on' ? 1 : 0;
        if($req->hasFile('image')){
            Storage::disk('public')->delete($image_url); // Delete old image
            $image = $req->file('image');
            $image_url = $image->store('images', 'public');
        }

        $product->product_category_id = $req->category_id;
        $product->title = $req->title;
        $product->description = $req->description;
        $product->image_url = $image_url;
        $product->order_count = 0;
        $product->view = 0;
        $product->instock = $instock;
        $product->disable = 0;
        $product->save();

        return back()->with('msg','The product have been successfully updated');

    }
    public function manageStatus(Request $req, $id){
        $req->validate([
            'status'=>'required|numeric',
        ]);
        $status = $req->status;
        $product = Product::find($id);
        $product->disable = $status;
        $product->save();
        return back()->with('msg','The product was successfully disable');
    }

    public function deleteImage($product_id, $image_id){
        $image = ProductImage::find($image_id);
        Storage::disk('public')->delete($image->image_url);
        $image->delete();
        return back()->with('imageMsg','The image was successfully deleted');
    }

    
}
