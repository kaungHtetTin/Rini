<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Customer;
use App\Models\Voucher;
use App\Models\VoucherItem;
use App\Models\Product;

class VoucherController extends Controller
{
    public function store(Request $req){
        $req->validate([
            'items'=> 'required',
            'name'=>'required',
            'phone'=>'required',
            'address'=>'required',
            'image'=>'required',
        ]);

        if(!$req->hasFile('image')) return ['status'=>'fail'];
        
        $trade = false;
        if(isset($req->trade)){
            $trade = true;
        }

        $image = $req->file('image');
        $image_url = $image->store('payments', 'public');

        $phone = $req->phone;
        $name = $req->name;
        $address = $req->address;
        $items = json_decode($req->items,true);

        $customer = Customer::where('phone',$phone)->first();
        if(!$customer){
            $customer = new Customer();
            $customer->phone = $phone;
            $customer->collaborate = 0;
        }

        $customer->name = $name;
        $customer->address = $address;
        $customer->save();

        $voucher = new Voucher();
        $voucher->customer_id = $customer->id;
        $voucher->total_amount = 0;
        $voucher->screenshot_url = $image_url;
        $voucher->message = "";
        $voucher->payment_verified = 0;
        $voucher->delivered = 0;
        $voucher->total_amount = 0;
        $voucher->trade = 0;
        $voucher->save();

        $purchased_items = [];
        $total_amount = 0;
        foreach($items as $item){
            $quantity = $item['quantity'];
            if($quantity>0){
                $product = Product::find($item['id']);
                $price = $product->price;
                $discount = $product->discount;
                $discount = $price*$discount/100;

                $final_price = $price - $discount;

                if($trade && $customer->collaborate == 1){
                    $final_price = $product->trade_price;
                    $voucher->trade = 1;
                    $voucher->save();
                }

                $amount = $final_price*$quantity;
                $total_amount+= $amount;

                $purchased_items [] = [
                    'voucher_id'=>$voucher->id,
                    'product_id'=>$product->id,
                    'price'=>$final_price,
                    'quantity'=>$quantity,
                    'amount'=>$amount,
                    'created_at'=>$voucher->created_at,
                    'updated_at'=>$voucher->updated_at,
                ];

                $product->order_count = $product->order_count + $quantity;
                $product->save();
            }
        }
        VoucherItem::insert($purchased_items);
        $voucher->total_amount = $total_amount;
        $voucher->save();
        return ['status'=>'success'];
    }
}
