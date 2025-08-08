<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\VoucherItem;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;

class VoucherController extends Controller
{
    public function new_orders(){
        $vouchers = Voucher::where('delivered',0)->paginate(100);
        return view('admin.vouchers-new',[
            'page_title'=>'New Orders',
            'vouchers'=>$vouchers,
        ]);
    }
    public function delivered_orders(){
         $vouchers = Voucher::where('delivered',1)->paginate(100);
        return view('admin.vouchers-delivered',[
            'page_title'=>'Delivered Orders',
            'vouchers'=>$vouchers,
        ]);
    }

    public function show($id){
        $voucher = Voucher::find($id);
        return view('admin.vouchers-detail',[
            'page_title' => 'Detail',
            'voucher'=>$voucher,
        ]);
    }

    public function payment_verified($id){
        $voucher = Voucher::find($id);
        $voucher->payment_verified = 1;
        $voucher->save();
        return back()->with('msg','The payment for the voucher has been verified');
    }

    public function delivered(Request $req, $id){
        if($req->message == null){
            $message = "";
        }else{
            $message = $req->message;
        }
        $voucher = Voucher::find($id);
        if(!$voucher) return redirect()->route('admin.404');
        $voucher->delivered = 1;
        $voucher->message = $message;
        $voucher->save();
        return back()->with('msg','The payment for the voucher has been verified');
    }

    public function add(){
        $products = Product::where('disable',0)->get();
        return view('admin.vouchers-add',[
            'page_title'=>'Add Order',
            'products'=>$products,
        ]);
    }

    public function destroy($id){
        $voucher = Voucher::find($id);
        $voucher->delete();
        return redirect()->route('admin.vouchers.new-orders');
    }

    public function saleOverview(){

        if(isset($req->year)) $year = $req->year;
        else $year = date('Y');

        $day = date('d');
        $month = date('m');

        $saleRateByCategory = VoucherItem::selectRaw(DB::raw("sum(quantity) as total_quantity, products.product_category_id"))
        ->where(DB::raw("YEAR(voucher_items.created_at)"),$year)
        ->join('products','products.id','=','voucher_items.product_id')
        ->groupBy("products.product_category_id")
        ->get();

        $product_categories = ProductCategory::where('disable',0)->get();

        $demanding_products =  VoucherItem::selectRaw(DB::raw("sum(quantity) as total_quantity, product_id"))
        ->where('vouchers.delivered',0)
        ->join('vouchers','vouchers.id','=','voucher_items.voucher_id')
        ->groupBy('product_id')
        ->orderBy('total_quantity','desc')
        ->get();

        $daily_sale_rates =  VoucherItem::selectRaw(DB::raw("sum(quantity) as total_quantity,DAY(created_at) as day"))
        ->where(DB::raw("YEAR(voucher_items.created_at)"),date('Y'))
        ->where(DB::raw("MONTH(voucher_items.created_at)"),date('m'))
        ->groupBy('day')
        ->get();

        $trending_products =  VoucherItem::selectRaw(DB::raw("sum(quantity) as total_quantity, product_id"))
        ->where(DB::raw("YEAR(voucher_items.created_at)"),$year)
        ->groupBy('product_id')
        ->orderBy('total_quantity','desc')
        ->limit(10)
        ->get();

        return view('admin.vouchers-sale-overview',[
            'page_title'=>'Sale Overview',
            'saleRateByCategory'=>$saleRateByCategory,
            'year'=>$year,
            'product_categories'=>$product_categories,
            'demanding_products'=>$demanding_products,
            'daily_sale_rates'=>$daily_sale_rates,
            'trending_products'=>$trending_products,
        ]);
    }
}
