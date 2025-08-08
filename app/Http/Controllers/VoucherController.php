<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\VoucherList;
use App\Models\Customer;


class VoucherController extends Controller
{

    public function index(Request $req){
        $phone = "";
        if(isset($req->phone)) $phone = $req->phone;

        $customer = Customer::where('phone',$phone)->first();
        if($customer){
            $vouchers = Voucher::where('customer_id',$customer->id)->orderBy('id','desc')->get();
        }else{
            $vouchers = [];
        }

        return view('my-orders',[
            'page_title'=>'My Order',
            'vouchers'=>$vouchers,
            'customer'=>$customer,
            'phone'=>$phone,
        ]);

    }

    public function show($id){
        $voucher = Voucher::find($id);
        if(!$voucher) return redirect()->route('404');
        return view('my-order-show',[
            'page_title'=>'Detail',
            'voucher'=>$voucher,
        ]);
    }

    public function store(Request $req){
        $req->validate([
            'items'=> 'required',
            'name'=>'required',
            'phone'=>'required'
        ]);
        
        return $req;
    }
}
