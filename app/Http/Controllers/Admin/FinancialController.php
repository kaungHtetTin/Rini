<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FinancialType;
use App\Models\FinancialCategory;
use App\Models\Financial;
use App\Models\SalaryRecord;
use App\Models\Voucher;
use Illuminate\Support\Facades\DB;

class FinancialController extends Controller
{
    public function index(Request $req){
        $categories = FinancialCategory::where('financial_type_id',2)->get();
        if(isset($req->category_id)){
            $financial_category_id = $req->category_id;
            $financials = Financial::where('financial_category_id',$financial_category_id)->orderBy('id','desc')->paginate(100);
        }else{
            $financial_category_id = 0;
            $financials = Financial::orderBy('id','desc')->paginate(100);
        }
        
        return view('admin.financials',[
            'page_title'=>'Outcome',
            'categories'=>$categories,
            'financials'=>$financials,
            'financial_category_id'=>$financial_category_id,

        ]);
    }

    public function add(){
        $categories = FinancialCategory::where('financial_type_id',2)->where('id','>',2)->get();
        return view('admin.financials-add',[
            'page_title'=>'Add Cost',
            'categories'=>$categories,
        ]);
    }

    public function store(Request $req){
        $req->validate([
            'category_id'=>'required',
            'title'=>'required',
            'amount'=>'required|numeric',
        ]);

        $financial = new Financial();
        $financial->financial_type_id = 2;
        $financial->financial_category_id = $req->category_id;
        $financial->title = $req->title;
        $financial->amount = $req->amount;
        $financial->save();

        return back()->with('msg','New cost was successfully added');

    }

    public function destroy($id){
        $financial = Financial::find($id);
        $financial_category_id = $financial->financial_category_id;
        if($financial_category_id < 3){
            SalaryRecord::where('financial_id',$id)->delete();
        }
        $financial->delete();
        return back()->with('msg','The record was successfully deleted');
    }

    public function overview(Request $req){
        if(isset($req->year)) $year = $req->year;
        else $year = date('Y');

        $day = date('d');
        $month = date('m');

        $saleOfYear = DB::table('vouchers')
        ->selectRaw(DB::raw("sum(total_amount) as amount, MONTH(created_at) as month"))
        ->where(DB::raw("YEAR(created_at)"),$year)
        ->groupBy("month")
        ->get();

        $costOfYear = DB::table('financials')
        ->selectRaw(DB::raw("sum(amount) as amount, MONTH(created_at) as month"))
        ->where(DB::raw("YEAR(created_at)"),$year)
        ->where('financial_type_id',2)
        ->groupBy("month")
        ->get();

        $costs =  DB::table('financials')
        ->selectRaw("sum(amount) as amount,financial_category_id")
        ->where('financials.financial_type_id',2)
        ->where(DB::raw("YEAR(created_at)"),$year)
        ->groupBy("financial_category_id")
        ->get();

        $allCosts =  DB::table('financials')
        ->selectRaw("sum(amount) as amount,financial_category_id")
        ->where('financials.financial_type_id',2)
        ->groupBy("financial_category_id")
        ->get();

        $categories = FinancialCategory::where('financial_type_id',2)->get();

        $sale_today = Voucher::where(DB::raw("YEAR(created_at)"),date('Y'))
        ->where(DB::raw("MONTH(created_at)"),$month)
        ->where(DB::raw("DAY(created_at)"),$day)
        ->sum('total_amount');

        $sale_current_month = Voucher::where(DB::raw("YEAR(created_at)"),date('Y'))
        ->where(DB::raw("MONTH(created_at)"),$month)
        ->sum('total_amount');

        $sale_current_year = Voucher::where(DB::raw("YEAR(created_at)"),date('Y'))
        ->sum('total_amount');

        $sale_all_time = Voucher::sum('total_amount');

        $cost_today = Financial::where(DB::raw("YEAR(created_at)"),date('Y'))
        ->where(DB::raw("MONTH(created_at)"),$month)
        ->where(DB::raw("DAY(created_at)"),$day)
        ->where('financials.financial_type_id',2)
        ->sum('amount');

        $cost_current_month = Financial::where(DB::raw("YEAR(created_at)"),date('Y'))
        ->where(DB::raw("MONTH(created_at)"),$month)
        ->where('financials.financial_type_id',2)
        ->sum('amount');

        $cost_current_year = Financial::where(DB::raw("YEAR(created_at)"),date('Y'))
        ->where('financials.financial_type_id',2)
        ->sum('amount');

        $cost_all_time = Financial::where('financials.financial_type_id',2)
        ->sum('amount');

        foreach($categories as $category){
            foreach($costs as $cost){
                if($cost->financial_category_id == $category->id){
                    $cost->category = $category->category;
                }
            }
            foreach($allCosts as $cost){
                if($cost->financial_category_id == $category->id){
                    $cost->category = $category->category;
                }
            }
            
        }
    

        return view('admin.financials-overview',[
            'page_title'=>'Financial Overview',
            'saleOfYear'=>$saleOfYear,
            'costOfYear'=>$costOfYear,
            'allCosts'=>$allCosts,
            'costs'=>$costs,
            'year'=>$year,
            'sale_today'=>$sale_today,
            'sale_current_month'=>$sale_current_month,
            'sale_current_year'=>$sale_current_year,
            'sale_all_time'=>$sale_all_time,
            'cost_today'=>$cost_today,
            'cost_current_month'=>$cost_current_month,
            'cost_current_year'=>$cost_current_year,
            'cost_all_time'=>$cost_all_time,

        ]);
    }
}
