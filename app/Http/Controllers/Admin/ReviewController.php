<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index(){
        $reviews = Review::orderBy('id','desc')->paginate(100);
        return view('admin.reviews',[
            'reviews'=>$reviews,
            'page_title'=>'Reviews',
        ]);
    }

    public function destroy($id){
        $review = Review::find($id);
        $review->delete();
        return back()->with('msg','The blog was successfully deleted');
    }
}
