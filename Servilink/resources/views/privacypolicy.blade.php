<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Servilink | Privacy Policy</title>
    <meta name="description" content="Servilink">
    <meta name="author" content="">
    {{-- <link rel="shortcut icon" href="favicon.ico"> --}}
    <title> @yield('title') | Servilink</title>
    <link rel="icon" href="{{ asset('img/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('img/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('img//apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('img//apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img//apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('img//apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('img//apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('img//apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('img//apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img//apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('img//android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img//favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('img//favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img//favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('img//manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('img//ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">


    <link href='https://fonts.googleapis.com/css?family=Lato:300,400,300italic,400italic' rel='stylesheet'
        type='text/css'>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/toastr/toastr.css') }}">
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
    <link rel="stylesheet" href="{!! asset('assets/css/bootstrap.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/css/animate.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/css/font-awesome.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/css/component.css') !!}">

    <link rel="stylesheet" href="{!! asset('assets/css/owl.theme.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/css/owl.carousel.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/css/vegas.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/css/style.css') !!}">

    <!-- Google web font  -->
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700,300' rel='stylesheet' type='text/css'>

</head>

<body id="top" data-spy="scroll" data-offset="50" data-target=".navbar-collapse">
    <div class="preloader">
        <div class="sk-spinner sk-spinner-pulse"></div>
    </div>
    <section id="home">
        <div class="container">
           
        </div>
    </section>

    <footer class="footer footermod">
        <div class="container text-center">
            <small class="copyright">Powered by <a href="http://servilink.systems" target="_blank"> <img
                        src="{{ asset('img/logo.png') }}" width="20px" height="20px" alt="Servilink"
                        style=" max-width:80px; height: auto;"></a> Servilink</small>
            <div class="ftr-1"><i class="fa fa-copyright"></i> <?php echo date('Y'); ?>  Servilink Rights
                Reserved.</div>
        </div>
        <!--//container-->
    </footer>
    <a href="#" class="go-top"><i class="fa fa-angle-up"></i></a>

    <!-- Javascript  -->
    <script src="{!! asset('assets/js/jquery.js') !!}"></script>
    <script src="{!! asset('assets/js/bootstrap.min.js') !!}"></script>
    <script src="{!! asset('assets/js/vegas.min.js') !!}"></script>
    <script src="{!! asset('assets/js/modernizr.custom.js') !!}"></script>
    <script src="{!! asset('assets/js/toucheffects.js') !!}"></script>
    <script src="{!! asset('assets/js/owl.carousel.min.js') !!}"></script>
    <script src="{!! asset('assets/js/smoothscroll.js') !!}"></script>
    <script src="{!! asset('assets/js/wow.min.js') !!}"></script>
    <script src="{!! asset('assets/js/custom.js?v=2') !!}"></script>
    <script type="text/javascript" src="{{ asset('assets/toastr/toastr.js') }}"></script>
    <script type="text/javascript" src="{!! asset('assets/js/main.js') !!}"></script>
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
