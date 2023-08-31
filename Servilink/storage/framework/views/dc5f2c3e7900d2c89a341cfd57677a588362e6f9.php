<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('img/favicon-16x16.png')); ?>">
    <title>Servilink | Page not found</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>" rel="stylesheet">


    <!-- animation CSS -->
    <link href="<?php echo e(asset('dash/css/animate.css')); ?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo e(asset('dash/css/style.css')); ?>" rel="stylesheet">
    <!-- color CSS -->
    <link href="<?php echo e(asset('dash/css/colors/default.css')); ?>" id="theme" rel="stylesheet">

</head>

<body>
    <!-- Preloader -->

    <section id="wrapper" class="error-page">
        <div class="error-box">
            <div class="error-body text-center">
                <h1 class="text-danger">404</h1>
                <h3 class="text-uppercase">Page Not Found !</h3>
                <p class="text-muted m-t-30 m-b-30">YOU SEEM TO BE TRYING TO FIND HIS WAY HOME</p>
                <a href="<?php echo e(route('welcome')); ?>" class="btn btn-danger btn-rounded waves-effect waves-light m-b-40">Back to home</a>
            </div>
            <footer class="footer text-center"> <i class="fa fa-copyright"></i> <?php echo date('Y'); ?> Servilink Rights
                Reserved.</footer>
        </div>
    </section>



    <script src="<?php echo e(asset('dash/plugins/bower_components/jquery/dist/jquery.min.js')); ?>"></script>

    <script src="<?php echo e(asset('assets/js/bootstrap.min.js')); ?>"></script>


</body>

</html>
<?php /**PATH /home/ocqv5p3q51h2/Servilink/resources/views/errors/404.blade.php ENDPATH**/ ?>