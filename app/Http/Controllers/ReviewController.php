<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Customer;

class ReviewController extends Controller
{
    public function index(){

    }

    public function store(Request $req){
        $req->validate([
            'name'=>'required',
            'phone'=>'required',
            'message'=>'required',
        ]);

        $phone = $req->phone;
        $customer = Customer::where('phone',$phone)->first();
        if(!$customer){
            $customer = new Customer();
            $customer->name = $req->name;
            $customer->phone = $phone;
            $customer->address = "";
            $customer->save();
        }

        $review = new Review();
        $review->customer_id = $customer->id;
        $review->message = $req->message;
        $review->save();

        return back()->with('msg','Thanks for your review. RiNi is always listening to your sound.');

    }
}
