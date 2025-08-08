<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\MobileBanking;

class PaymentMethodController extends Controller
{
    public function index(){
        $payment_methods = PaymentMethod::all();
        return view('admin.payment-methods',[
            'page_title' => 'Payment Methods',
            'payment_methods'=>$payment_methods,
        ]);
    }

    public function add(){
        $mobile_bankings = MobileBanking::all();
        return view('admin.payment-methods-add',[
            'page_title' => 'Payment Methods',
            'mobile_bankings'=>$mobile_bankings,
        ]);
    }

    public function store(Request $req){
        $req->validate([
            'phone'=>'required',
        ]);

        $phone = $req->phone;
        $mobile_bankings = MobileBanking::all();
        foreach($mobile_bankings as $banking){
            $id = $banking->id;
            $key = "banking_$id";

            if(isset($req->$key)){
                if($req->$key == 'on'){
                    $payment_method = new PaymentMethod();
                    $payment_method->mobile_banking_id = $banking->id;
                    $payment_method->phone = $phone;
                    $payment_method->save();
                }
            }
        }

        return back()->with('msg','The new admin was successfully added');
    }

    public function destroy($id){
        $payment_method = PaymentMethod::find($id);
        $payment_method->delete();

        return back()->with('msg','The blog was successfully deleted');
    }
}
