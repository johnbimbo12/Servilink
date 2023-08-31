<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Servilink | Welcome</title>
    <meta name="description" content="Servilink">
    <meta name="author" content="">
    
    <title> <?php echo $__env->yieldContent('title'); ?> | Servilink</title>
    <link rel="icon" href="<?php echo e(asset('img/favicon.ico')); ?>">
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo e(asset('img/apple-icon-57x57.png')); ?>">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo e(asset('img//apple-icon-60x60.png')); ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo e(asset('img//apple-icon-72x72.png')); ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo e(asset('img//apple-icon-76x76.png')); ?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo e(asset('img//apple-icon-114x114.png')); ?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo e(asset('img//apple-icon-120x120.png')); ?>">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo e(asset('img//apple-icon-144x144.png')); ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo e(asset('img//apple-icon-152x152.png')); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('img//apple-icon-180x180.png')); ?>">
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo e(asset('img//android-icon-192x192.png')); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('img//favicon-32x32.png')); ?>">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo e(asset('img//favicon-96x96.png')); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('img//favicon-16x16.png')); ?>">
    <link rel="manifest" href="<?php echo e(asset('img//manifest.json')); ?>">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo e(asset('img//ms-icon-144x144.png')); ?>">
    <meta name="theme-color" content="#ffffff">


    <link href='https://fonts.googleapis.com/css?family=Lato:300,400,300italic,400italic' rel='stylesheet'
        type='text/css'>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/toastr/toastr.css')); ?>">
    <style>
        .footermod {
            position: fixed;
            left: 0;
            bottom: 0;
            margin: auto;
            padding-top: 20px;
            padding-bottom: 20px;
            width: 100%;
            text-align: center;
        }

    </style>
    <link rel="stylesheet" href="<?php echo asset('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('assets/css/animate.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('assets/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('assets/css/component.css'); ?>">

    <link rel="stylesheet" href="<?php echo asset('assets/css/owl.theme.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('assets/css/owl.carousel.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('assets/css/vegas.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('assets/css/style.css'); ?>">

    <!-- Google web font  -->
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700,300' rel='stylesheet' type='text/css'>

</head>

<body id="top" data-spy="scroll" data-offset="50" data-target=".navbar-collapse">
    <div class="preloader">
        <div class="sk-spinner sk-spinner-pulse"></div>
    </div>
    <div class="navbar-default navbar-fixed-top" role="navigation" style="">
        <div style="text-align: left; margin-left: 40px">

            <a class="navbar-brand smoothScroll" href="#top">
                <span class="logo-title"><img src="<?php echo e(asset('img/logo.png')); ?>" width="28px" height="28px"
                        alt="Servilink">
                        <span class="hidden-xs" style="color: black"> Servilink
                </span>
                </span>
            </a>

        </div>
        <div style="text-align: right; margin-right: 40px; margin-top: 10px">
            <?php if(auth()->guard()->guest()): ?>
                <?php if(Route::has('login')): ?>
                    <a class="" href=" <?php echo e(route('login')); ?>">
                        <span class="logo-title" style="color:black;font-size: 18px;"><?php echo e(__('Login')); ?></span>
                    </a>
                <?php endif; ?>
            <?php else: ?>
                <a class="" href=" <?php echo e(route('dashboard')); ?>">
                    <span class="logo-title" style="color: black; font-size: 18px;"><?php echo e(__('Dashboard')); ?></span>
                </a>
            <?php endif; ?>
        </div>
        <br>
    </div>


    <section id="home">
        <div class="overlay"></div>
        <div class="container">
            <div style="margin: auto">
                <div class=" wow fadeInUp" data-wow-delay="0.3s">

                    <div class="align-items-center justify-content-center">

                        <div class="col-md-offset-1 col-md-10 col-sm-12 wow fadeInUp" data-wow-delay="0.3s">
                            <h1><b>All Estate Services in One Platform</b> </h1>
                            <div class="row" id="main">
                                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-6">
                                    <a class="smoothScroll btn btn-success btn-lg wow fadeInUp"
                                        href="<?php echo e(route('instantpay')); ?>" data-wow-delay="1.2s" data-id="" style="padding-top:20px;padding-bottom: 20px; background: #eebf3f;
                                    border: 1px solid #eebf3f;color: #fff;width: 100%">Residents
                                    </a>
                                </div>
                                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-6">
                                    <a class="smoothScroll btn btn-success btn-lg wow fadeInUp"
                                        href="<?php echo e(route('login')); ?>" data-wow-delay="1.2s" data-id=""
                                        style="padding-top:22px;padding-bottom: 22px;width: 100%">Facility
                                        Managers</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <footer class="footer footermod">
        <div class="container text-center">
            <small class="copyright">Powered by <a href="http://servilink.systems" target="_blank"> <img
                        src="<?php echo e(asset('img/logo.png')); ?>" width="20px" height="20px" alt="Servilink"
                        style=" max-width:80px; height: auto;"></a> Servilink</small>
            <div class="ftr-1"><i class="fa fa-copyright"></i> <?php echo date('Y'); ?>  Servilink Rights
                Reserved.</div>
        </div>
        <!--//container-->
    </footer>
    <a href="#" class="go-top"><i class="fa fa-angle-up"></i></a>

    <!-- Javascript  -->
    <script src="<?php echo asset('assets/js/jquery.js'); ?>"></script>
    <script src="<?php echo asset('assets/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo asset('assets/js/vegas.min.js'); ?>"></script>
    <script src="<?php echo asset('assets/js/modernizr.custom.js'); ?>"></script>
    <script src="<?php echo asset('assets/js/toucheffects.js'); ?>"></script>
    <script src="<?php echo asset('assets/js/owl.carousel.min.js'); ?>"></script>
    <script src="<?php echo asset('assets/js/smoothscroll.js'); ?>"></script>
    <script src="<?php echo asset('assets/js/wow.min.js'); ?>"></script>
    <script src="<?php echo asset('assets/js/custom.js?v=2'); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/toastr/toastr.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('assets/js/main.js'); ?>"></script>
    <script>
        $(document).ready(function(e) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });
            $(document).on("click", "a", function(e) {
                $(".preloader").css("display", "flex");
            });
        });
    </script>
</body>

</html>
<?php /**PATH /home/ocqv5p3q51h2/Servilink/resources/views/welcome.blade.php ENDPATH**/ ?>