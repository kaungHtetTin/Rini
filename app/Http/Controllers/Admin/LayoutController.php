<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\Customer;
use App\Models\VoucherItem;
use App\Models\PaymentMethod;


class LayoutController extends Controller
{
    public function index(Request $req){

        if(isset($req->year)) $year = $req->year;
        else $year = date('Y');

        $new_orders = Voucher::where('payment_verified',0)->count();
        $monthly_earning = Voucher::where(DB::raw("YEAR(created_at)"),date('Y'))
                            ->where(DB::raw("MONTH(created_at)"),date('m'))
                            ->sum('total_amount');
        $annual_earning = Voucher::where(DB::raw("YEAR(created_at)"),date('Y'))
                            ->sum('total_amount');
        $total_customer = Customer::count();

        $saleOfYear = DB::table('vouchers')
        ->selectRaw(DB::raw("sum(total_amount) as amount, MONTH(created_at) as month"))
        ->where(DB::raw("YEAR(created_at)"),$year)
        ->groupBy("month")
        ->get();

        $demanding_products =  VoucherItem::selectRaw(DB::raw("sum(quantity) as total_quantity, product_id"))
        ->where('vouchers.delivered',0)
        ->join('vouchers','vouchers.id','=','voucher_items.voucher_id')
        ->groupBy('product_id')
        ->orderBy('total_quantity','desc')
        ->get();
        

        return view('admin.index',[
            'page_title'=>'Dashboard',
            'new_orders'=>$new_orders,
            'monthly_earning'=>$monthly_earning,
            'annual_earning'=>$annual_earning,
            'total_customer'=>$total_customer,
            'saleOfYear'=>$saleOfYear,
            'demanding_products'=>$demanding_products,
        ]);
    }
}
