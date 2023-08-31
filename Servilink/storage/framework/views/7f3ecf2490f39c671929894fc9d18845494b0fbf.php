<?php $__env->startSection('title', 'Thank you'); ?>
<?php $__env->startSection('content'); ?>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="container">
                    <div class="row align-items-center justify-content-center">
                        <div style="text-align: center;">
                            <h2 style="font-weight:bold; color: black">Thanks for using our service</h2>
                            <?php if($status=='error'): ?>
                              <h4 style="color: orange;margin-top: 10px">Transaction Fail !!!</h4>
                            <?php endif; ?>
                            <h4 style="color: white;margin-top: 15px;margin-bottom: 15px"><?php echo e($msg); ?></h4>
                            <a href="<?php echo e(route('instantpay')); ?>" class="align-items-center justify-content-center">

                                <div class="container-login100-form-btn col">
                                    <button type="submit" class="login100-form-btn">
                                        <?php echo e(__('Go Back')); ?>

                                    </button>

                                </div>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.loginapp', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ocqv5p3q51h2/Servilink/resources/views/thankyou.blade.php ENDPATH**/ ?>