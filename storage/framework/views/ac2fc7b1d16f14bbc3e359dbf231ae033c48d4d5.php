<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <style>
        .active_subscription{
            pointer-events: none;
        }

        .active_subscription .card{
            background: rgba(0,0,0,0.2);
        }
    </style>
     <?php $__env->slot('header', null, []); ?> 
        <div class="d-flex justify-content-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Plans
            </h2>
            <?php if(auth()->user()->is_admin): ?>
            <a href="<?php echo e(route('create.plan')); ?>" class=" btn btn-info">Create New Plan</a>
            <?php endif; ?>
        </div>
     <?php $__env->endSlot(); ?>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <?php if(session()->has('sm')): ?>
                    <div class="alert alert-success"><?php echo e(session()->get('sm')); ?></div>
                    <?php endif; ?>

                    <?php if(session()->has('em')): ?>
                    <div class="alert alert-danger"><?php echo e(session()->get('em')); ?></div>
                    <?php endif; ?>

                    <div class="row">
                        <?php $__currentLoopData = $plans['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <div class="col-sm-4 <?php echo e(auth()->user()->subscribed($plan->id) ? 'active_subscription' : ''); ?> " >
                            <div class="card" style="width: 18rem;">
                                <img src="..." class="card-img-top" alt="...">
                                <?php if(auth()->user()->is_admin): ?>
                                <form class="delele-form" action="<?php echo e(route('delete.plan')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="product_id" value="<?php echo e($plan->id); ?>">
                                    <button type="submit" class="mr-3 btn-danger btn btn-sm">Delete</button>
                                </form>
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo e($plan['name']); ?></h5>
                                    <p class="card-text"><?php echo e($plan['description']); ?></p>
                                    <?php $prices = getPlanPrices($plan->id);// echo '<pre>'; print_r($prices);   ?>
                                    <?php if($prices || !empty($prices)): ?>
                                    <ul>
                                        <?php $__currentLoopData = $prices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $price): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="mt-3 ">
                                            <div class="d-flex justify-content-between">
                                                <h5>  $<?php echo e(number_format($price->unit_amount / 100,2)); ?> <?php echo e($price->recurring->interval); ?></h5>
                                                <?php if(!auth()->user()->is_admin): ?>
                                                <a href="<?php echo e(route('plans.show',$price->id)); ?>" class=" btn btn-outline-dark pull-right">Choose</a>
                                                <?php endif; ?>
                                            </div>
                                        </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        $(document).on('submit','form.delele-form',function(){
         return confirm('are you sure to delete this record?');
        });
    </script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH /Applications/xampp/xamppfiles/htdocs/lc-cashier-stripe-example-master/resources/views/plans/index.blade.php ENDPATH**/ ?>