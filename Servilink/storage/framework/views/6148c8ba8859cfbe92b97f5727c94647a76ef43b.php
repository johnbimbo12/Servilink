<?php $__env->startSection('title', 'Facility Manager'); ?>
<?php $__env->startSection('content'); ?>
    <style>
        .mobile {
            margin-top: 0px;
            margin-bottom: 0px
        }


        @media (max-width: 960px) {
            .mobile {
                margin-top: 900px;
                margin-bottom: 100px;
            }
        }

        @media (max-width: 760px) {

            .mobile {
                margin-top: 900px;
                margin-bottom: 100px;
            }
        }

    </style>
    <section id="home">
        <div class="container">
            <div class="mobile">
                <h1 style="text-align: center; font-weight: bold;margin-bottom:50px; margin-top: 0px;  color: #313131;
                            font-family: Rubik, sans-serif;"> Choose a service</h1>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <div class="white-box"
                            style="border-radius: 20px;padding: 15px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                            <a href="<?php echo e(route('residents')); ?>">
                                <h3 class="box-title">Residence Management</h3>
                                <ul class="list-inline two-part">
                                    <li style="text-align: center">
                                        <span> <i class="mdi mdi-account-multiple fa-fw"></i></span>
                                    </li>
                                </ul>
                                <h5>Manage Residence</h5>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <div class="white-box"
                            style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                            <a href="<?php echo e(route('power.manage')); ?>">
                                <h3 class="box-title">POWER</h3>
                                <ul class="list-inline two-part">
                                    <li style="text-align: center">
                                        <span> <i class="mdi mdi-lightbulb-on fa-fw" style="color: orange"></i></span>
                                    </li>
                                </ul>
                                <h5>Manage Power</h5>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 ">
                        <div class="white-box"
                            style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                            <a href="<?php echo e(route('water.manage')); ?>">
                                <h3 class="box-title">WATER</h3>
                                <ul class="list-inline two-part">
                                    <li style="text-align: center">
                                        <span> <i class="mdi mdi-water-pump fa-fw"></i></span>
                                    </li>

                                </ul>
                                <h5>Manage Water</h5>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <div class="white-box"
                            style="border-radius: 20px;padding: 15px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                            <a href="<?php echo e(route('diesel.manage')); ?>">
                                <h3 class="box-title">MANAGE DIESEL</h3>
                                <ul class="list-inline two-part">
                                    <li style="text-align: center">
                                        <span><i class="mdi mdi-gas-station fa-fw" style="color: orange"></i></span>
                                    </li>
                                </ul>
                                <h5>Manage Diesel</h5>
                            </a>
                        </div>

                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <div class="white-box"
                            style="border-radius: 20px;padding: 15px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                            <a href="<?php echo e(route('service.charges')); ?>" class="product">
                                <h3 class="box-title">SERVICE CHARGES</h3>
                                <ul class="list-inline two-part">
                                    <li style="text-align: center">
                                        <span> <i class="mdi mdi-worker fa-fw" style="color: orange"></i></span>
                                    </li>
                                </ul>
                                <h5>Manage Service Charges </h5>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <div class="white-box"
                            style="border-radius: 20px;padding: 15px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                            <a href="<?php echo e(route('messaging')); ?>" class="product">
                                <h3 class="box-title">PROCESS REQUEST</h3>
                                <ul class="list-inline two-part">
                                    <li style="text-align: center">
                                        <span> <i class="mdi mdi-wechat fa-fw"></i></span>
                                    </li>
                                </ul>
                                <h5>Manage Requests</h5>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ocqv5p3q51h2/Servilink/resources/views/manager/dashboard.blade.php ENDPATH**/ ?>