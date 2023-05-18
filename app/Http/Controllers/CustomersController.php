<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class CustomersController extends Controller
{  

    protected $stripe;
    public function __construct() 
    {
        $this->stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
    }

    public function customers(){
        $customers  = $this->stripe->customers->all([
            'expand' => ['data.subscriptions'],
          ]);

        return view('customers.customers',['customers' => $customers]);
    }

    public function show($customer){
       $the_customer = $this->stripe->customers->retrieve($customer,[
       'expand' => ['subscriptions']
       ]);
    //    return  $the_customer;
       return view('customers.show',['the_customer' => $the_customer]);
    }

    public function subscriptionCancel(Request $request){

        $subscription_id = $request->subscription_id;
        try{
            $user  = User::where('stripe_id',$request->user_id)->first();
            $user->subscription($request->product_id)->cancelNow();
            $invoices = $user->invoices()->filter(function($invoice) use ($subscription_id) {
                return $invoice->subscription === $subscription_id;
            });
            $the_invoice = collect($invoices)->values()->toArray()[0];
            $user->refund($the_invoice['payment_intent']);
            setMessage('Subscriptions Canceled Successfully with Refund Payment.!');
        }catch(\Exception $e){
            // return $e;
            setMessage('Something went wrong.!','em');
        }
    
        return back();
    }

}
