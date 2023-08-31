 
 <?php $__env->startSection('title', 'Residents Dashboard'); ?>
 <?php $__env->startSection('content'); ?>
     <style>
         .mobile {
             margin-top: 0px;
             margin-bottom: 0px
         }

         @media (max-width: 960px) {
             .mobile {
                 margin-top: 400px;
                 margin-bottom: 100px;
             }
         }

         @media (max-width: 760px) {
             .mobile {
                 margin-top: 400px;
                 margin-bottom: 100px;
             }
         }

     </style>
     <section id="home">
         <div class="container">
             <div class="mobile">
                 <h1 style="text-align: center; font-weight: bold;margin: 0;  color: #313131;
                                font-family: Rubik, sans-serif;"> Welcome</h1>
                 <h1 style="text-align: center; font-weight: bold;margin-bottom:50px; margin-top: 0px;  color: #313131;
                                font-family: Rubik, sans-serif;"> Choose a
                     product or
                     service</h1>
                 <div class="row">
                     <div class="col-lg-4 col-sm-6 col-xs-12 " id="power">
                         <div class="white-box"
                             style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                             <a href="<?php echo e(route('power.manage')); ?>">
                                 <h3 class="box-title">MANAGE POWER</h3>
                                 <ul class="list-inline two-part">
                                     <li style="text-align: center">
                                         <span> <i class="mdi mdi-lightbulb-on fa-fw"></i></span>
                                     </li>
                                 </ul>
                             </a>
                         </div>
                     </div>
                     <div class="col-lg-4 col-sm-6 col-xs-12 " id="power">
                         <div class="white-box"
                             style="border-radius: 20px;padding: 14px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                             <a href="<?php echo e(route('water.manage')); ?>">
                                 <h3 class="box-title">MANAGE WATER</h3>
                                 <ul class="list-inline two-part">
                                     <li style="text-align: center">
                                         <span> <i class="mdi mdi-water-pump fa-fw" style="color: black"></i></span>
                                     </li>
                                 </ul>
                             </a>
                         </div>
                     </div>

                     <div class="col-lg-4 col-sm-6 col-xs-12 " id="power">
                         <div class="white-box"
                             style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                             <a href="<?php echo e(route('visitor.manage')); ?>" class="product">
                                 <h3 class="box-title">MANAGE VISITOR</h3>
                                 <ul class="list-inline two-part">
                                     <li style="text-align: center">
                                         <span> <i class="icon-people"></i></span>
                                     </li>

                                 </ul>
                             </a>
                         </div>
                     </div>
                 </div>
                 <div class="row">

                     <div class="col-lg-4 col-sm-6 col-xs-12 " id="power">
                         <div class="white-box"
                             style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                             <a href="<?php echo e(route('service.charges')); ?>" class="product">
                                 <h3 class="box-title">SERVICE CHARGE</h3>
                                 <ul class="list-inline two-part">
                                     <li style="text-align: center">
                                         <span> <i class="fa fa-dollar" style="color: black"></i></span>
                                     </li>
                                 </ul>
                             </a>
                         </div>
                     </div>

                     <div class="col-lg-4 col-sm-6 col-xs-12" id="power">
                         <div class="white-box"
                             style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                             <a href="<?php echo e(route('messaging')); ?>" class="product">
                                 <h3 class="box-title">MESSAGING</h3>
                                 <ul class="list-inline two-part">
                                     <li style="text-align: center">
                                         <span> <i class="fa  fa-comment fa-7x"></i></span>
                                     </li>

                                 </ul>
                             </a>
                         </div>
                     </div>
                     <div class="col-lg-4 col-sm-6 col-xs-12" id="power">
                         <div class="white-box"
                             style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                             <a href="#" class="product">
                                 <h3 class="box-title">HOUSEHOLD STORE</h3>
                                 <ul class="list-inline two-part">
                                     <li style="text-align: center">
                                         <span> <i class="fa  fa-cart-plus fa-7x" style="color: black"></i></span>
                                     </li>

                                 </ul>
                             </a>
                         </div>
                     </div>

                 </div>
             </div>
         </div>
     </section>
 <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ocqv5p3q51h2/Servilink/resources/views/resident/dashboard.blade.php ENDPATH**/ ?>