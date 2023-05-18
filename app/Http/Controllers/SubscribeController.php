<?php

namespace App\Http\Controllers;

use Stripe\Issuing\Card;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{

    public function subscribeForm()
    {
        $user = auth()->user();
        return view('subscribe', ['intent' => $user->createSetupIntent()]);
    }

    public function subscribed(Request $request)
    {
        $user = auth()->user();
        try {
            $user->newSubscription($request->product_id, $request->plan)->create($request->paymentMethod, [
                'name' => $user->name,
                'address' => [
                    'line1' => $request->address,
                    'postal_code' => $request->postal_code,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country' => $request->country,
                ],
            ]);
            setMessage('Plan Buy Successfully.!');
        } catch (Card $exception) {
            $user->asStripeCustomer()->delete();
            $user->delete();
            setMessage('Something Went Wrong.!','em');
        }

        return redirect()->route('dashboard');
    }


    public function userChargeForm()
    {
        return view('charge');
    }

    public function userCharged(Request $request)
    {
        // auth()->user()->charge(1000, $request->paymentMethod);
        // dd($request->all());
        $user = auth()->user();
        $user->createAsStripeCustomer();
        $user->updateDefaultPaymentMethod($request->paymentMethod);
        $user->invoiceFor('One Time Fee', 1500);
        return redirect('/dashboard');
    }
}
