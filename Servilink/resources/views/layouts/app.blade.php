<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @laravelPWA
    <title> @yield('title') | Servilink</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="{!! asset('assets/css/font-awesome.min.css') !!}">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-tagsinput/tagsinput.css') }}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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

        @media screen and (min-width: 601px) {
            .ibzlf {
                font-size: 60px;

            }

            .pur {
                font-size: 40px;
            }

        }

        /* If the screen size is 600px wide or less, set the font-size of <div> to 30px */
        @media screen and (max-width: 600px) {
            .ibzlf {
                font-size: 30px;
            }

            .pur {
                font-size: 20px;
            }

        }

    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm" style="  background: white;
        color: white;">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('img/logo.png') }}" style=" max-width:50px; height: auto;"
                        alt="Access by ArcticOS">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();**document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
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
</body>

</html>
