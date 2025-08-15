<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Price;

class PriceController extends Controller
{
    public function index($product_id){
        $product = Product::find($product_id);
        return view('admin.products-prices',[
            'product'=>$product,
            'page_title'=>'Edit Prices',
        ]);
    }

    public function store(Request $req){
        
        $req->validate([
            'quantity'=>'required',
            'price'=>'required',
            'product_id'=>'required',
        ]);

        $quantity = $req->quantity;
        $price = $req->price;
        $product_id = $req->product_id;
        $priceModel = Price::where('product_id',$product_id)->where('quantity',$quantity)->first();
        if($priceModel){
            $priceModel->price = $price;
            $priceModel->save();
        }else{
            $priceModel = new Price();
            $priceModel->product_id = $product_id;
            $priceModel->quantity = $quantity;
            $priceModel->price = $price;
            $priceModel->save();
        }

        return back()->with('msg','The new price have been saved successfully');

    }

    public function destroy($id){
        $price = Price::find($id);
        $price->delete();
        return back()->with('msg','The new price have been deleted successfully');
    }
}
