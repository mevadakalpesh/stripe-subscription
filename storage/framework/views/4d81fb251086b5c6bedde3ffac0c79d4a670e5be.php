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
            Add New Plan
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <form action="<?php echo e(route('store.plan')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="plan name">Plan Name:</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter Plan Name">
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-danger"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group">
                            <label for="cost">Cost:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">$</div>
                                </div>
                                <input type="number" class="form-control" name="cost" id="inlineFormInputGroupUsername"
                                    placeholder="Enter Cost">
                                  
                            </div>
                            <?php $__errorArgs = ['cost'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-danger"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>


                        <div class="form-group">
                            <label for="cost">Time Period :</label>
                            <select name="interval" class="form-control">
                                <option value="month">Month</option>
                                <option value="year">Year</option>
                                <option value="week">Week</option>
                                <option value="day">Day</option>
                            </select>
                            <?php $__errorArgs = ['interval'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-danger"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="form-group">
                            <label for="cost">Plan Description:</label>
                            <textarea name="description" class="form-control" cols="30" rows="10"></textarea>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-danger"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="anothe-price-wapper mt-3 mb-3" data-totalrow="1">
                            <div class="price-item row">
                                <div class="form-group col-sm-6">
                                    <label for="">Cost</label>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="">Time Period :</label>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-info" id="add_price">Add another price</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        $(document).on('click','#add_price',function(){
          var totalrow =   $('.anothe-price-wapper').attr('data-totalrow');
    
          var price_item = '<div class="price-item row mt-3">'+
                                '<div class="form-group col-sm-5">'+
                                    '<div class="input-group">'+
                                        '<div class="input-group-prepend">'+
                                            '<div class="input-group-text">$</div>'+
                                        '</div>'+
                                        '<input class="form-control" name="product_prices['+totalrow+'][unit_amount]" type="number">'+
                                    '</div>'+
                                '</div>'+
                                '<div class="form-group col-sm-5">'+
                                    '<select name="product_prices['+totalrow+'][interval]" class="form-control">'+
                                        '<option value="month">Month</option>'+
                                        '<option value="year">Year</option>'+
                                        '<option value="week">Week</option>'+
                                        '<option value="day">Day</option>'+
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-2">'+
                                    '<button type="button" class="btn btn-danger remove_price_fiels">Delete</button>'+
                                '</div>'+
                            '</div>';
    
      
           $('.anothe-price-wapper').append(price_item);
           $('.anothe-price-wapper').attr('data-totalrow',parseInt(totalrow) + 1);
           
        });
    
        $(document).on('click','.anothe-price-wapper .remove_price_fiels',function(e){
         e.preventDefault();
         $(this).parents('.price-item').remove()    ;
        });
    </script>
    <?php $__env->stopPush(); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH /Applications/xampp/xamppfiles/htdocs/lc-cashier-stripe-example-master/resources/views/plans/create.blade.php ENDPATH**/ ?>