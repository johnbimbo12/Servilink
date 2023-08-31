<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @laravelPWA
    <title> @yield('title') | Servilink</title>

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{!! asset('assets/css/font-awesome.min.css') !!}">
    <!-- Menu CSS -->
    <link href="{{ asset('dash/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css') }}" rel="stylesheet">
    <!-- chartist CSS -->

    <link href="{!! asset('dash/plugins/datatables/dataTables.bootstrap4.min.css') !!}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('dash/plugins/toastr/toastr.css') }}">

    <!-- animation CSS -->
    <link href="{{ asset('dash/css/animate.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('dash/css/style.css') }}" rel="stylesheet">
    <!-- color CSS -->
    <link href="{{ asset('dash/css/colors/default.css') }}" id="theme" rel="stylesheet">
    <!-- Google web font  -->
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{!! asset('assets/css/style.css') !!}">
    
    <link href="{!! asset('dash/plugins/datatables/dataTables.bootstrap4.min.css') !!}" rel="stylesheet">
    <link href="{{ asset('assets/bootstrap.daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet"
        type="text/css">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/button/css/buttons.dataTables.min.css') }}" />

    <link href="{{ asset('dash/plugins/bower_components/datatables/jquery.dataTables.min.css') }}" rel="stylesheet"
        type="text/css" />

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

    <style>
        .Absolute-Center {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: #313131;
            font-family: Rubik, sans-serif;
            margin: 10px 0;
            font-weight: 300;
        }

    </style>

</head>

<body id="top">
    <div class="preloader">
        <div class="sk-spinner sk-spinner-pulse"></div>
    </div>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top m-b-0"
            style="padding-left:0px;position: fixed; top: 0; width: 100%">
            <div class="navbar-header" style="background-color: white">
                <div class="top-left-part">
                    <!-- Logo -->
                    <a class="logo" href="{{ route('welcome') }}" style="color: black">
                        <img src="{{ asset('img/logo.png') }}" alt="home" class="dark-logo" width="40px"
                            height="40px" />
                        <!--This is light logo icon--><img src="{{ asset('img/logo.png') }}" alt="home"
                            class="light-logo" width="40px" height="40px" />
                        <span class="hidden-xs" style="font-weight: bolder">Servilink</span>
                    </a>
                </div>
                @guest
                    @if (Route::has('login'))
                        <ul class="nav navbar-top-links navbar-right pull-right">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}"
                                    style="font-size: 18px">{{ __('Login') }}</a>
                            </li>
                        </ul>
                    @endif
                @else
                    @if (url()->current() == route('dashboard'))
                        <ul class="nav navbar-top-links navbar-right pull-right">
                            {{-- <li>
                                <form role="search" class="app-search hidden-sm hidden-xs m-r-10">
                                    <input type="text" placeholder="Search..." class="form-control"> <a href=""><i
                                            class="fa fa-search"></i></a>
                                </form>
                            </li> --}}
                            <li class="dropdown">
                                <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img
                                        src="{{ asset('dash/plugins/images/users/varun.jpg') }}" alt="user-img"
                                        width="36" class="img-circle"><b
                                        class="hidden-xs" style="color:black">{{ auth()->user()->name }}</b><span
                                        class="caret"></span> </a>
                                <ul class="dropdown-menu dropdown-user animated flipInY">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img
                                                    src="{{ asset('dash/plugins/images/users/varun.jpg') }}"
                                                    alt="user" />
                                            </div>
                                            <div class="u-text">
                                                <h4>{{ auth()->user()->name }}</h4>
                                                <p class="text-muted">{{ auth()->user()->email }}</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>

                                    <li>
                                        <div style="margin-left:20px">
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                                                 document.getElementById('logout-form').submit();">
                                                <i class="fa fa-power-off"></i> {{ __('Logout') }}
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                                <!-- /.dropdown-user -->
                            </li>
                            <!-- /.dropdown -->
                        </ul>
                    @endif
                    @endif
                </div>
            </nav>

        </div>
        @yield('content')
        @include('modal.info')
        <footer class="footer footermod">
            <div class="container text-center">
                <small class="copyright">Powered by <a href="http://servilink.systems" target="_blank"> <img
                            src="{{ asset('img/logo.png') }}" width="20px" height="20px" alt="Servilink"
                            style=" max-width:80px; height: auto;"></a> Servilink</small>
                <div class="ftr-1"><i class="fa fa-copyright"></i> <?php echo date('Y'); ?> Servilink Rights
                    Reserved.</div>
            </div>
            <!--//container-->
        </footer>
        <a href="#" class="go-top"><i class="fa fa-angle-up"></i></a>

        <script src="{{ asset('dash/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
        
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <!-- Javascript  -->
        <script type="text/javascript" src="{{ asset('assets/toastr/toastr.js') }}"></script>
        <script type="text/javascript" src="{!! asset('assets/js/main.js') !!}"></script>
        <!-- Bootstrap Core JavaScript -->

        <!--slimscroll JavaScript -->
        <script src="{{ asset('dash/js/jquery.slimscroll.js') }}"></script>

        <!-- Menu Plugin JavaScript -->
        <script src="{{ asset('dash/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>
        <!--slimscroll JavaScript -->



        <script src="{{ asset('dash/js/jquery.slimscroll.js') }}"></script>
        <!--Wave Effects -->
        <script src="{{ asset('dash/plugins/bower_components/styleswitcher/jQuery.style.switcher.js') }}"></script>

        <!-- Custom Theme JavaScript -->
        <script src="{{ asset('dash/js/custom.min.js') }}"></script>
        <script src="{{ asset('assets/popper.js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/bootstrap.daterangepicker/moment.min.js') }}"></script>
        <script src="{!! asset('assets/bootstrap.daterangepicker/daterangepicker.js') !!}"></script>
        <script src="{{ asset('dash/plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('dash/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/button/js/dataTables.buttons.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/button/js/buttons.flash.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/button/js/buttons.html5.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/button/js/buttons.print.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
        <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
        <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    </body>

    </html>
