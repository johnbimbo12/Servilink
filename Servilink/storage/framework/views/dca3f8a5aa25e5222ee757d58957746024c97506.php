<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title> <?php echo $__env->yieldContent('title'); ?> | Servilink</title>
    <?php $config = (new \LaravelPWA\Services\ManifestService)->generate(); echo $__env->make( 'laravelpwa::meta' , ['config' => $config])->render(); ?>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('loginpage/bootstrap/css/bootstrap.min.css')); ?>">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
        href="<?php echo e(asset('loginpage/fonts/font-awesome-4.7.0/css/font-awesome.min.css')); ?>">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
        href="<?php echo e(asset('loginpage/fonts/iconic/css/material-design-iconic-font.min.css')); ?>">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('loginpage/vendor/animate/animate.css')); ?>">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('loginpage/vendor/css-hamburgers/hamburgers.min.css')); ?>">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('loginpage/vendor/animsition/css/animsition.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('loginpage/css/util.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('loginpage/css/main.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/toastr/toastr.css')); ?>">
    <link rel="stylesheet" href="<?php echo asset('assets/css/animate.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('assets/css/component.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('assets/css/owl.theme.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('assets/css/owl.carousel.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('assets/css/vegas.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('assets/css/style.css'); ?>">
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
            background: white;
            color: black;
        }

        .ibzlf {
            text-transform: capitalize;
            font-weight: bolder;
        }

        .pur {
            font-weight: bold;
            margin-bottom: 10px;
        }

        @media  screen and (min-width: 601px) {
            .ibzlf {
                font-size: 60px;

            }

            .pur {
                font-size: 40px;
            }

        }

        /* If the screen size is 600px wide or less, set the font-size of <div> to 30px */
        @media  screen and (max-width: 600px) {
            .ibzlf {
                font-size: 30px;
            }

            .pur {
                font-size: 20px;
            }

        }

    </style>
</head>

<body data-spy="scroll" data-offset="50">
    <div style="opacity: 0.9;">
        <div class="preloader">
            <div class="sk-spinner sk-spinner-pulse"></div>
        </div>

        <?php echo $__env->yieldContent('content'); ?>
    </div>
    <script src="<?php echo asset('assets/js/jquery.js'); ?>"></script>
    <!--===============================================================================================-->
    <script src="<?php echo e(asset('loginpage/vendor/animsition/js/animsition.min.js')); ?>"></script>
    <!--===============================================================================================-->
    <script src="<?php echo e(asset('assets/popper.js/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('loginpage/bootstrap/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo asset('assets/js/vegas.min.js'); ?>"></script>
    <script src="<?php echo asset('assets/js/modernizr.custom.js'); ?>"></script>
    <script src="<?php echo asset('assets/js/toucheffects.js'); ?>"></script>
    <script src="<?php echo asset('assets/js/owl.carousel.min.js'); ?>"></script>
    <script src="<?php echo asset('assets/js/smoothscroll.js'); ?>"></script>
    <script src="<?php echo asset('assets/js/wow.min.js'); ?>"></script>
    <script src="<?php echo asset('assets/js/custom.js?v=3'); ?>"></script>
    
    <script src="https://bani-assets.s3.eu-west-2.amazonaws.com/static/widget/js/pop.js" async></script>
    <script src="<?php echo asset('assets/toastr/toastr.min.js'); ?>"></script>
    <script>
        $(document).ready(function(e) {
            $("form button[type=submit]").click(function() {
                $(".preloader").css("display", "flex");
            });

            $(document).on("click", "a", function(e) {
                $(".preloader").css("display", "flex");
            });
        });
    </script>

</body>

</html>
<?php /**PATH /home/ocqv5p3q51h2/Servilink/resources/views/layouts/loginapp.blade.php ENDPATH**/ ?>