<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon-16x16.png') }}">
    <title>Servilink | Page Not Found</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">


    <!-- animation CSS -->
    <link href="{{ asset('dash/css/animate.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('dash/css/style.css') }}" rel="stylesheet">
    <!-- color CSS -->
    <link href="{{ asset('dash/css/colors/default.css') }}" id="theme" rel="stylesheet">

</head>

<body>
    <!-- Preloader -->

    <section id="wrapper" class="error-page">
        <div class="error-box">
            <div class="error-body text-center">
                <h1 class="text-danger">400</h1>
                <h3 class="text-uppercase">Page Not Found !</h3>
                <p class="text-muted m-t-30 m-b-30">YOU SEEM TO BE TRYING TO FIND HIS WAY HOME</p>
                <a href="{{route('welcome')}}" class="btn btn-danger btn-rounded waves-effect waves-light m-b-40">Back to home</a>
            </div>
            <footer class="footer text-center"> <i class="fa fa-copyright"></i> <?php echo date('Y'); ?> Servilink Rights
                Reserved.</footer>
        </div>
    </section>
    <script src="{{ asset('dash/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>

    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
</body>

</html>
