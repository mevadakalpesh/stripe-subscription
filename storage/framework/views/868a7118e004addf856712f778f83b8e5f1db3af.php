<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <style>
        #card-element {
            width: 60% !important;
        }
    </style>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Subscribe
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <p>You will be charged $<?php echo e(number_format($the_product_price['unit_amount'] / 100,2)); ?> <?php echo e($the_product_price['recurring']['interval']); ?> for <?php echo e($the_product['name']); ?> Plan</p>

                     <div id="response_message">
                       
                     </div>

                    <form action="<?php echo e(route('subscribe.post')); ?>" method="post" id="payment-form"   data-secret="<?php echo e($intent->client_secret); ?>">
                        <?php echo csrf_field(); ?>
                    <input type="hidden" name="product_id" value="<?php echo e($the_product['id']); ?>">
                        <div class="">
                            <div class="form-group">
                                <label for="standard"><?php echo e($the_product['name']); ?> - $<?php echo e(number_format($the_product_price['unit_amount'] / 100,2)); ?> / <?php echo e($the_product_price['recurring']['interval']); ?></label> <br>
                                <input type="hidden" name="plan" id="standard" value="<?php echo e($the_product_price['id']); ?>">
                            </div>
                            <br>
                            <h3>Billing Address</h3>
                            <br>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="cardholder-name">Address</label>
                                        <input type="text" name="address" id="cardholder-address" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="cardholder-name">Postal Code</label>
                                        <input type="text" name="postal_code" id="cardholder-postal_code"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="cardholder-name">City</label>
                                        <input type="text" name="city" id="cardholder-city" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="cardholder-name">State</label>
                                        <input type="text" name="state" id="cardholder-state" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="cardholder-name">Country</label>
                                        <select id="cardholder-country" class="form-control" name="country">
                                            <option value=" ">Select Country</option>
                                            <?php $__currentLoopData = getCountries(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country_code => $country_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($country_code); ?>" <?php echo e("US" == $country_code ? 'selected' : ''); ?>><?php echo e($country_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                 
                                    </div>
                                </div>


                            </div>


                            <label for="card-element">
                                Credit or debit card
                            </label>
                            <div id="card-element">
                                <!-- A Stripe Element will be inserted here. -->
                            </div>

                            <!-- Used to display form errors. -->
                            <div id="card-errors" role="alert"></div>
                        </div>
                        <div class="d-flex">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['class' => 'mt-4','id' => 'subscribe_now_btn']]); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'mt-4','id' => 'subscribe_now_btn']); ?>
                                Subscribe Now
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <img src="<?php echo e(asset('loading.gif')); ?>" class="mt-3 loading_image" width="70px" alt="" style="display: none;">
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php $__env->startPush('scripts'); ?>
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        // Create a Stripe client.
            var stripe = Stripe('pk_test_51LmHA3SDuZWLQN2PfIPL7BWKZ6MRjmfjH47TnRaRNErqPD1m54UrIp3nqjhMsJ0Sh9JTBztBgTb0SkB3w11OHzPD00ij0MzNeT');
            // Create an instance of Elements.
            var elements = stripe.elements();

            // Custom styling can be passed to options when creating an Element.
            // (Note that this demo uses a wider set of styles than the guide below.)
            var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
            };

            // Create an instance of the card Element.
            var card = elements.create('card', {style: style});

            // Add an instance of the card Element into the `card-element` <div>.
            card.mount('#card-element');
            // Handle real-time validation errors from the card Element.
            card.on('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
            });

            // Handle form submission.
            var form = document.getElementById('payment-form');
            var cardHolderAddress = document.getElementById('cardholder-address');
            var cardHolderPostalCode = document.getElementById('cardholder-postal_code');
            var cardHolderCity = document.getElementById('cardholder-city');
            var cardHolderState = document.getElementById('cardholder-state');
            var cardHolderCountry = document.getElementById('cardholder-country');
            var clientSecret = form.dataset.secret;

            form.addEventListener('submit', async function(event) {
                $('#response_message').html(' ');
                event.preventDefault();
                $('#subscribe_now_btn').prop('disabled',true);
                $('.loading_image').show();

                if(cardHolderAddress.value && cardHolderPostalCode.value && cardHolderCity.value &&  cardHolderState.value &&  cardHolderCountry.value){
                    const { setupIntent, error } = await stripe.confirmCardSetup(
                        clientSecret, {
                            payment_method: {
                                card,
                                // billing_details: { 
                                //     address: {
                                //         city: cardHolderCity.value,
                                //         country: null,
                                //         line1: cardHolderAddress.value,
                                //         line2: null,
                                //         postal_code: cardHolderPostalCode.value,
                                //         state: cardHolderState.value
                                //     },
                                // }
                            }
                        }
                    );

                    if (error) {
                        // Inform the user if there was an error.
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = error.message;
                    } else {
                        // Send the token to your server.
                        stripeTokenHandler(setupIntent);
                    }
                }else{
                  $('#response_message').html('<div class="alert alert-danger">All are Fields Required .Please Fill</div>');
                }
                // stripe.createToken(card).then(function(result) {
                //     if (result.error) {
                //     // Inform the user if there was an error.
                //     var errorElement = document.getElementById('card-errors');
                //     errorElement.textContent = result.error.message;
                //     } else {
                //     // Send the token to your server.
                //     stripeTokenHandler(result.token);
                //     }
                // });
            });

            // Submit the form with the token ID.
            function stripeTokenHandler(setupIntent) {
                // Insert the token ID into the form so it gets submitted to the server
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'paymentMethod');
                hiddenInput.setAttribute('value', setupIntent.payment_method);
                form.appendChild(hiddenInput);

                // Submit the form
                form.submit();
            }
    </script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH /Applications/xampp/xamppfiles/htdocs/lc-cashier-stripe-example-master/resources/views/subscribe.blade.php ENDPATH**/ ?>