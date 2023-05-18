<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PlanCreateRequest;
use Dompdf\Exception;

class PlanController extends Controller
{
    protected $stripe;
    public function __construct() 
    {
        $this->stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
    }

    public function index()
    {  
        $plans = $this->stripe->products->all(['active' => true]);
        return view('plans.index',['plans' => $plans]);
    }


    public function show($price_id, Request $request)
    {    
        $the_product_price =  $this->stripe->prices->retrieve($price_id,[]);
        $the_product =  $this->stripe->products->retrieve($the_product_price['product'],[]);
        return view('subscribe', [
            'intent' => auth()->user()->createSetupIntent(),
            'the_product_price' => $the_product_price,
            'the_product' => $the_product,
        ]);
    }


    public function createPlan()
    {
        return view('plans.create');
    }
   

    public function storePlan(PlanCreateRequest $request)
    {
        $data = $request->except('_token');
        $data['slug'] = strtolower($data['name']);
        $price = $data['cost'] * 100;
        
        //create stripe product 
        $stripeProduct = $this->stripe->products->create([
            'name' => $data['name'],
            'description' => $data['description']
        ]);

        //Stripe Plan Creation
        $stripePlanCreation = $this->stripe->plans->create([
            'amount' => $price,
            'currency' => 'usd',
            'interval' => $request->interval, //  it can be day,week,month or year
            'product' => $stripeProduct->id,
        ]);

        $data['stripe_plan'] = $stripePlanCreation->id;

        //create mutiple price
        if ($request->product_prices || !empty($request->product_prices)) {
            foreach ($request->product_prices as  $product_price) {
                $this->stripe->prices->create(
                    [
                        'product' => $stripePlanCreation->product,
                        'unit_amount' => $product_price['unit_amount'] * 100,
                        'currency' => 'usd',
                        'recurring' => ['interval' => $product_price['interval']],
                    ]
                );
            }
        }

        return redirect()->route('plans')->with('success','Plan Create Successfully');
    }



    public function deletePlan(Request $request){

      try{
        $response =  $this->stripe->products->update($request->product_id,['active' => false]);
        setMessage('Plan Deleted Successfully.!');
        return redirect()->route('plans');
      }catch(\Exception $e){
        setMessage($e->getError()->message,'em');
       return redirect()->route('plans');
      }
    }
}
