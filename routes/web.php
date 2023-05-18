<?php

use App\Http\Controllers\CustomersController;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\SubscribeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function(){

    Route::get('/dashboard', function () { return view('dashboard');  })->name('dashboard');
    Route::get('/posts',[PostController::class,'index'])->name('posts');
    Route::middleware(['payingCustomer'])->get('/members', function () { return view('members'); })->name('members');


    Route::controller(PlanController::class)->group(function(){
        Route::get('/plans','index')->middleware('nonPayingCustomer')->name('plans');
        Route::get('/plan/{plan}','show')->middleware('nonPayingCustomer')->name('plans.show');
        Route::get('/create/plan','createPlan')->name('create.plan');
        Route::post('/store/plan','storePlan')->name('store.plan');
        Route::post('/delete/plan','deletePlan')->name('delete.plan');
    });

    Route::controller(SubscribeController::class)->middleware(['nonPayingCustomer'])->group(function(){
        Route::get('/subscribe','subscribeForm')->name('subscribe');
        Route::post('/subscribe','subscribed')->name('subscribe.post');
    });


    Route::get('/charge',[SubscribeController::class,'userChargeForm'])->name('charge');
    Route::post('/charge',[SubscribeController::class,'userCharged'])->name('charge.post');



    Route::get('/invoices', function () {
        return view('invoices', ['invoices' => auth()->user()->invoices()]);
    })->name('invoices');
    

    Route::controller(CustomersController::class)->middleware(['isAdminCheck'])->prefix('/customers')->group(function(){
      Route::get('/','customers')->name('customers');
      Route::get('/show/{customer}','show')->name('customer.show');
      Route::post('/subscriptions/cancel/','subscriptionCancel')->name('subscriptionCancel');
    });
    
});



Route::get('user/invoice/{invoice}', function (Request $request, $invoiceId) {
    return $request->user()->downloadInvoice($invoiceId, [
        'vendor' => 'Your Company',
        'product' => 'Your Product',
    ]);
});

Route::post(
    'stripe/webhook',
    [WebhookController::class, 'handleWebhook']
);
