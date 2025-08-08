<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FinancialCategory;

class CostCategoryController extends Controller
{
    public function index(){

        $categories = FinancialCategory::where('financial_type_id',2)->get();
        return view('admin.cost-categories',[
            'page_title'=>'Financial Setting',
            'categories'=>$categories,
        ]);
    }

    public function store(Request $req){
        $req->validate([
            'category'=>'required',
        ]);

        $category = new FinancialCategory();
        $category->financial_type_id = 2;
        $category->category = $req->category;
        $category->save();

        return back()->with('msg','New Cost Category was successfully added');
    }

    public function modify(Request $req, $id){
         $req->validate([
            'category'=>'required',
        ]);
        $category = FinancialCategory::find($id);
        $category->category = $req->category;
        $category->save();
        return back()->with('msg','New Cost Category was successfully updated');
    }
}
