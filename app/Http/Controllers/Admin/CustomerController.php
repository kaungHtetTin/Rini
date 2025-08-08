<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Voucher;
use App\Models\Review;

class CustomerController extends Controller
{
    public function index(Request $req){
        
        if(isset($req->search)){
            $search = $req->search;
            $customers = Customer::where('phone',$search)
            ->orWhere('name','like',"%$search%")
            ->paginate(50);
        }else{
            $customers = Customer::orderBy('id','desc')
            ->where('collaborate',0)->paginate(50);
        }
 
        return view('admin.customers',[
            'page_title'=>'Customers',
            'customers'=>$customers,
        ]);
    }

    public function add(){
         return view('admin.customers-add',[
            'page_title' =>'Collaborators',
        ]);
    }

    // add collaborator
    public function store(Request $req){
        $req->validate([
            'name'=>'required',
            'phone'=>'required|numeric',
            'address'=>'required',
        ]);

        $phone = $req->phone;
        $name = $req->name;
        $address = $req->address;

        $customer = Customer::where('phone',$phone)->first();
        if(!$customer){
            $customer = new Customer();
            $customer->phone = $phone;
        }

        $customer->collaborate = 1;
        $customer->name = $name;
        $customer->address = $address;
        $customer->save();
        return back()->with('msg','The new collaborator was successfully added');
    }

    public function showCollaborators(Request $req){
         if(isset($req->search)){
            $search = $req->search;
            $customers = Customer::where('phone',$search)
            ->orWhere('name','like',"%$search%")
            ->paginate(50);
        }else{
            $customers = Customer::orderBy('id','desc')
            ->where('collaborate',1)->paginate(50);
        }
 
        return view('admin.customers',[
            'page_title'=>'Collaborators',
            'customers'=>$customers,
        ]);
    }

    public function show($id){
        $customer = Customer::find($id);
        $total_purchase = Voucher::where('customer_id',$id)->sum('total_amount');
        $total_review = Review::where('customer_id',$id)->count();
        return view('admin.customers-show',[
            'page_title'=>'Detail',
            'customer'=>$customer,
            'total_purchase'=>$total_purchase,
            'total_review'=>$total_review,
        ]);
    }

}
