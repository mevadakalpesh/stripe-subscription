<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('the Customer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session()->has('sm'))
            <div class="alert alert-success">{{ session()->get('sm') }}</div>
            @endif
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg pb-3 pt-3 pr-3 pl-3">
                <p><b> Name : </b> {{ $the_customer->name }} </p>
                <p><b> Email : </b> {{ $the_customer->email }} </p>

                <h3>Billing address</h3>
                <p><b>City : </b> {{ $the_customer->address->city }} </p>
                <p><b>Country : </b> {{ $the_customer->address->country }} </p>
                <p><b>Address : </b> {{ $the_customer->address->line1 }} </p>
                <p><b>Postal Code : </b> {{ $the_customer->address->postal_code }} </p>
                <p><b>State : </b> {{ $the_customer->address->state }} </p>

                <h3>Subscriptions</h3>
                <p><b>Total : </b> {{ count($the_customer->subscriptions) }} </p>

                <div class="row pb-3">
                        @foreach ($the_customer->subscriptions->data as $subscription)
                            <div class="col-sm-4">
                                <div class="card" style="width: 18rem;">
                                    <div class="card-body">
                                    <p>  <b>Status :</b> {{ $subscription->status }} </p>
                                    <p>  <b>Start Date :</b> {{ date('d-m-Y',$subscription->current_period_start) }} </p>
                                    <p>  <b>End Date :</b> {{ date('d-m-Y',$subscription->current_period_end) }} </p>
                                    <h5>subscription items</h5>
                                    <ul>
                                        <?php $plan_id = ''; ?>
                                        @foreach ($subscription->items->data as $item)
                                        @php
                                        $plan_id = $item->plan->product;
                                        $the_product = getProduct($item->plan->product);
                                        @endphp
                                            <li>  <p>  <b>Amount :</b> {{ $item->plan->currency == 'usd' ? '$' : 'Rs'}}{{ number_format($item->plan->amount / 100,2) }} / {{ $item->plan->interval  }}  </p></li>
                                            <h4> Plan Details</h4>
                                            <p>  <b>Name:</b> {{ $the_product->name   }} </p>
                                            <p>  <b>Description :</b> {{ $the_product->name   }}</p>
                                        @endforeach
                                    </ul>
                                    <form class="form-subscriptionCancel" action="{{ route('subscriptionCancel') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="subscription_id" value="{{ $subscription->id }}">
                                        <input type="hidden" name="user_id" value="{{ $the_customer->id }}">
                                        <input type="hidden" name="product_id" value="{{ $plan_id }}">
                                        <button class="btn btn-danger btn-sm" type="submit">Cancel Subscription</button>
                                       </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        $(document).on('submit','form.form-subscriptionCancel',function(){
            return confirm('are you sure Cancel the Subscription ?')
        })
    </script>
        
    @endpush
</x-app-layout>