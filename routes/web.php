<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LayoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\BlogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------

| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function () {
    
   
});
require __DIR__.'/auth.php';

Route::get('/',[LayoutController::class,'index'])->name('home');
Route::get('/cart',[LayoutController::class,'cart'])->name('cart');
Route::get('/buy',[LayoutController::class,'buy'])->name('buy');
Route::get('/buy-now',[LayoutController::class,'buyNow'])->name('buy-now');
Route::get('/collaborate',[LayoutController::class,'collaborate'])->name('collaborate');
Route::get('/trade',[LayoutController::class,'trade'])->name('trade');
Route::post('/trade',[LayoutController::class,'checkTrader']);

Route::get('/products',[ProductController::class,'index'])->name('products');
Route::get('/products/{id}',[ProductController::class,'show'])->name('products-show');
Route::get('/products/{id}/buy',[ProductController::class,'buy'])->name('products-buy');

Route::get('/vouchers',[VoucherController::class,'index'])->name('vouchers');
Route::get('/vouchers/{id}',[VoucherController::class,'show'])->name('vouchers.show');

Route::get('/reviews',[ReviewController::class,'index'])->name('reviews');
Route::post('/reviews/add',[ReviewController::class,'store'])->name('reviews.store');

Route::get('/blogs',[BlogController::class,'index'])->name('blogs');
Route::get('/blogs/{id}',[BlogController::class,'show'])->name('blogs.show');

Route::get('/404',function(){
    return view('404',[
        'page_title'=>'404',
    ]);
})->name('404');

