<nav class="navbar navbar-default navbar-static-top m-b-0">
    <div class="navbar-header">
        <div class="top-left-part">
            <a class="logo" href="/">
                <!-- Logo -->
                <!--This is dark logo icon--><img src="<?php echo e(asset('img/favicon-32x32.png')); ?>" alt="home"
                    class="dark-logo" />
                <!--This is light logo icon--><img src="<?php echo e(asset('img/favicon-32x32.png')); ?>" alt="home"
                    class="light-logo" />
                </b>
                <!-- Logo text image you can use text also --><span class="hidden-xs" style="color: black"> Servilink
                </span>
            </a>
        </div>
        <ul class="nav navbar-top-links navbar-left">
            <li><a href="javascript:void(0)" class="open-close waves-effect waves-light"><i class="ti-menu"></i></a></li>

            <!--<li class="dropdown">-->
            <!--    <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="<?php echo e(route('messaging')); ?>"> <i class="mdi mdi-gmail"></i>-->
            <!--        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>-->
            <!--    </a>-->

            <!--</li>-->



            <?php if(Auth::user()->role == 4): ?>
            <li style="margin-left:10px"><a href="javascript:void(0)" class="open-close waves-effect waves-light" style="font-weight: bolder; font-size: 18px; color:black"><i class="mdi mdi-wallet fa-fw"></i>: ₦ <?php echo e(Auth::user()->estateuser->wallet_balance); ?></a></li>
            
            <?php elseif(Auth::user()->role == 1): ?>
            <li style="margin-left:10px"><a href="javascript:void(0)" class="open-close waves-effect waves-light" style="font-weight: bolder; font-size: 18px; color:black"><i class="mdi mdi-wallet fa-fw"></i>: ₦ <?php echo e($wallet); ?> <span style="font-size: 10px"> ( For admin vend)</span></a></li>
            <?php endif; ?>
           
            <!-- .Task dropdown -->

        </ul>
        <ul class="nav navbar-top-links navbar-right pull-right">

            <li class="dropdown">
                <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img
                        src="<?php echo e(asset('dash/plugins/images/users/varun.jpg')); ?>" alt="user-img" width="36"
                        class="img-circle"><b class="hidden-xs"><?php echo e(Auth::user()->name); ?></b><span
                        class="caret"></span> </a>
                <ul class="dropdown-menu dropdown-user animated flipInY">
                    <li>
                        <div class="dw-user-box">
                            <div class="u-img"><img src="<?php echo e(asset('dash/plugins/images/users/varun.jpg')); ?>"
                                    alt="user" /></div>
                            <div class="u-text">
                                <h4><?php echo e(Auth::user()->name); ?></h4>
                                <p class="text-muted"><?php echo e(Auth::user()->email); ?></p>
                            </div>
                        </div>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li><a href="#" data-toggle="modal" data-target="#changepassword"><i class="ti-settings"></i>
                            Change Password</a></li>
                    <li role="separator" class="divider"></li>
                    <li>
                        <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                            onclick="event.preventDefault();document.getElementById('logout-form3').submit();">
                            <i class="fa fa-power-off"></i>
                            <?php echo e(__('Logout')); ?>

                        </a>
                        <form id="logout-form3" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                            <?php echo csrf_field(); ?>
                        </form>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
    </div>
    <!-- /.navbar-header -->
    <!-- /.navbar-top-links -->
    <!-- /.navbar-static-side -->
</nav>
<?php /**PATH /home/ocqv5p3q51h2/Servilink/resources/views/layouts/nav.blade.php ENDPATH**/ ?>