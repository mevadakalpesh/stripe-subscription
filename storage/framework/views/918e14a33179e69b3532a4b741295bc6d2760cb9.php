<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('the Customer')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <?php if(session()->has('sm')): ?>
            <div class="alert alert-success"><?php echo e(session()->get('sm')); ?></div>
            <?php endif; ?>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg pb-3 pt-3 pr-3 pl-3">
                <p><b> Name : </b> <?php echo e($the_customer->name); ?> </p>
                <p><b> Email : </b> <?php echo e($the_customer->email); ?> </p>

                <h3>Billing address</h3>
                <p><b>City : </b> <?php echo e($the_customer->address->city); ?> </p>
                <p><b>Country : </b> <?php echo e($the_customer->address->country); ?> </p>
                <p><b>Address : </b> <?php echo e($the_customer->address->line1); ?> </p>
                <p><b>Postal Code : </b> <?php echo e($the_customer->address->postal_code); ?> </p>
                <p><b>State : </b> <?php echo e($the_customer->address->state); ?> </p>

                <h3>Subscriptions</h3>
                <p><b>Total : </b> <?php echo e(count($the_customer->subscriptions)); ?> </p>

                <div class="row pb-3">
                        <?php $__currentLoopData = $the_customer->subscriptions->data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-sm-4">
                                <div class="card" style="width: 18rem;">
                                    <div class="card-body">
                                    <p>  <b>Status :</b> <?php echo e($subscription->status); ?> </p>
                                    <p>  <b>Start Date :</b> <?php echo e(date('d-m-Y',$subscription->current_period_start)); ?> </p>
                                    <p>  <b>End Date :</b> <?php echo e(date('d-m-Y',$subscription->current_period_end)); ?> </p>
                                    <h5>subscription items</h5>
                                    <ul>
                                        <?php $plan_id = ''; ?>
                                        <?php $__currentLoopData = $subscription->items->data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                        $plan_id = $item->plan->product;
                                        $the_product = getProduct($item->plan->product);
                                        ?>
                                            <li>  <p>  <b>Amount :</b> <?php echo e($item->plan->currency == 'usd' ? '$' : 'Rs'); ?><?php echo e(number_format($item->plan->amount / 100,2)); ?> / <?php echo e($item->plan->interval); ?>  </p></li>
                                            <h4> Plan Details</h4>
                                            <p>  <b>Name:</b> <?php echo e($the_product->name); ?> </p>
                                            <p>  <b>Description :</b> <?php echo e($the_product->name); ?></p>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                    <form class="form-subscriptionCancel" action="<?php echo e(route('subscriptionCancel')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="subscription_id" value="<?php echo e($subscription->id); ?>">
                                        <input type="hidden" name="user_id" value="<?php echo e($the_customer->id); ?>">
                                        <input type="hidden" name="product_id" value="<?php echo e($plan_id); ?>">
                                        <button class="btn btn-danger btn-sm" type="submit">Cancel Subscription</button>
                                       </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
    <?php $__env->startPush('scripts'); ?>
    <script>
        $(document).on('submit','form.form-subscriptionCancel',function(){
            return confirm('are you sure Cancel the Subscription ?')
        })
    </script>
        
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH /Applications/xampp/xamppfiles/htdocs/lc-cashier-stripe-example-master/resources/views/customers/show.blade.php ENDPATH**/ ?>