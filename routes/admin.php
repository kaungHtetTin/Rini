<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\CostCategoryController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\SalaryRecordController;
use App\Http\Controllers\Admin\FinancialController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\LayoutController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\PriceController;

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
   
    Route::get('/404',function(){
        return view('admin.404',[
            'page_title'=>'404',
        ]);
    })->name('admin.404');

    Route::middleware('access_product')->group(function () {
        Route::get('/product-categories',[ProductCategoryController::class,'index'])->name('admin.product-categories');
        Route::post('/product-categories',[ProductCategoryController::class,'store'])->name('admin.product-categories.store');
        Route::put('/product-categories/{id}/manage-status',[ProductCategoryController::class,'manageStatus'])->name('admin.product-categoies.status');
        Route::put('/product-categories/{id}/modify',[ProductCategoryController::class,'modify'])->name('admin.product-categoies.modify');

        Route::get('/products',[ProductController::class,'index'])->name('admin.products');
        Route::get('/products/add',[ProductController::class,'add'])->name('admin.products-add');
        Route::post('/products/add',[ProductController::class,'store'])->name('admin.products-add');
        Route::get('/products/edit/{id}',[ProductController::class,'edit'])->name('admin.products-edit');
        Route::put('/products/edit/{id}',[ProductController::class,'modify'])->name('admin.products-edit');
        Route::put('/products/edit/{id}/manage-status',[ProductController::class,'manageStatus'])->name('admin.products-manage-status');
        Route::delete('/products/{pid}/images/delete/{iid}',[ProductController::class,'deleteImage'])->name('admin.products.images.delete');

        Route::get('/products/{pid}/prices',[PriceController::class,'index'])->name('admin.products.prices');
        Route::post('/prices/add',[PriceController::class,'store'])->name('admin.prices.add');
        Route::delete('/prices/{id}',[PriceController::class,'destroy'])->name('admin.prices.destroy');

    });

    Route::middleware('access_sale')->group(function () {
        Route::get('/vouchers/sale-overview',[VoucherController::class,'saleOverview'])->name('admin.vouchers.sale-overview');
        Route::get('/vouchers/new-orders',[VoucherController::class,'new_orders'])->name('admin.vouchers.new-orders');
        Route::get('/vouchers/delievered-orders',[VoucherController::class,'delivered_orders'])->name('admin.vouchers.delivered_orders');
        Route::get('/vouchers/add',[VoucherController::class,'add'])->name('admin.vouchers.add');
        Route::get('/vouchers/{id}',[VoucherController::class,'show'])->name('admin.vouchers.detail');
        Route::put('/vouchers/{id}/payment_verified',[VoucherController::class,'payment_verified'])->name('admin.vouchers.payment_verified');
        Route::put('/vouchers/{id}/delivered',[VoucherController::class,'delivered'])->name('admin.vouchers.delivered');
        Route::delete('/vouchers/{id}',[VoucherController::class,'destroy'])->name('admin.vouchers.delete');
    });

    Route::middleware('access_employee')->group(function () {
        Route::get('/departments',[DepartmentController::class,'index'])->name('admin.departments');
        Route::post('/departments',[DepartmentController::class,'store'])->name('admin.departments');
        Route::put('/departments/{id}',[DepartmentController::class,'modify'])->name('admin.departments.modify');
        
        Route::get('/employees',[EmployeeController::class,'index'])->name('admin.employees');
        Route::get('/employees/add',[EmployeeController::class,'add'])->name('admin.employees.add');
        Route::post('/employees',[EmployeeController::class,'store'])->name('admin.employees.store');
        Route::get('/employees/{id}',[EmployeeController::class,'show'])->name('admin.employees.show');
        Route::get('/employees/edit/{id}',[EmployeeController::class,'edit'])->name('admin.employees.edit');
        Route::put('/employees/edit/{id}',[EmployeeController::class,'modify'])->name('admin.employees.modify');
        Route::put('/employees/edit/{id}/manage-status',[EmployeeController::class,'manageStatus'])->name('admin.employees.manage-status');
        
        Route::post('/salary-records',[SalaryRecordController::class,'add'])->name('admin.salary-records.add');
        Route::delete('/salary-records/{id}',[SalaryRecordController::class,'destroy'])->name('admin.salary-records.destroy');

    });

    Route::middleware('access_financial')->group(function () {
        Route::get('/',[LayoutController::class,'index'])->name('admin.index');
        Route::get('/cost-categories',[CostCategoryController::class,'index'])->name('admin.cost-categories');
        Route::post('/cost-categories',[CostCategoryController::class,'store'])->name('admin.cost-categories');
        Route::put('/cost-categories/{id}',[CostCategoryController::class,'modify'])->name('admin.cost-categories.modify');

        Route::get('/financials/overview',[FinancialController::class,'overview'])->name('admin.financials.overview');
        Route::get('/financials',[FinancialController::class,'index'])->name('admin.financials');
        Route::get('/financials/add',[FinancialController::class,'add'])->name('admin.financials.add');
        Route::post('/financials/add',[FinancialController::class,'store'])->name('admin.financials.store');
        Route::delete('/financials/{id}',[FinancialController::class,'destroy'])->name('admin.financials.destroy');

    });

    Route::middleware('access_project')->group(function () {
        Route::get('/setting/update-contact',[SettingController::class,'contact'])->name('admin.setting.update-contact');
        Route::put('/setting/update-contact',[SettingController::class,'update_contact'])->name('admin.setting.update-contact');

        Route::get('/admins',[AdminController::class,'index'])->name('admin.admins');
        Route::get('/admins/add',[AdminController::class,'add'])->name('admin.admins.add');
        Route::post('/admins/add',[AdminController::class,'store'])->name('admin.admins.store');
        Route::get('/admins/{id}/edit',[AdminController::class,'edit'])->name('admin.admins.edit');
        Route::put('/admins/{id}/edit',[AdminController::class,'modify'])->name('admin.admins.modify');
        Route::put('/admins/mamage-status/{id}',[AdminController::class,'manageStatus'])->name('admin.admins.manage-status');

        Route::get('/payment-methods',[PaymentMethodController::class,'index'])->name('admin.payment-methods');
        Route::get('/payment-methods/add',[PaymentMethodController::class,'add'])->name('admin.payment-methods-add');
        Route::post('/payment-methods/add',[PaymentMethodController::class,'store'])->name('admin.payment-methods-store');
        Route::delete('/payment-methods/{id}',[PaymentMethodController::class,'destroy'])->name('admin.payment-methods-destroy');

        Route::get('/collaborated-customers',[CustomerController::class,'showCollaborators'])->name('admin.collaborators');
        Route::get('/customers/add',[CustomerController::class,'add'])->name('admin.customers.add');
        Route::post('/customers/add',[CustomerController::class,'store'])->name('admin.customers.store');
        

    });
    
    Route::get('/blogs',[BlogController::class,'index'])->name('admin.blogs');
    Route::get('/blogs/add',[BlogController::class,'add'])->name('admin.blogs.add');
    Route::post('/blogs/add',[BlogController::class,'store'])->name('admin.blogs.store');
    Route::get('/blogs/edit/{id}',[BlogController::class,'edit'])->name('admin.blogs.edit');
    Route::put('/blogs/edit/{id}',[BlogController::class,'modify'])->name('admin.blogs.modify');
    Route::delete('/blogs/{id}',[BlogController::class,'destroy'])->name('admin.blogs.destroy');
    Route::get('/blogs/{id}',[BlogController::class,'show'])->name('admin.blogs.show');

    Route::get('/customers',[CustomerController::class,'index'])->name('admin.customers');
    Route::get('/customers/{id}',[CustomerController::class,'show'])->name('admin.customers.show');

    Route::get('/reviews',[ReviewController::class,'index'])->name('admin.reviews');
    Route::delete('/reviews/{id}',[ReviewController::class,'destroy'])->name('admin.reviews.destroy');

});

Route::get('/login',function(){
    return view('admin.login');
})->name('admin.login');
Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('admin.login');
