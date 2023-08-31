<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | Servilink</title>
    @laravelPWA
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="{{ asset('dash/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('dash/css/style.css?v=2') }}" rel="stylesheet">
    <!-- color CSS -->
    <link href="{{ asset('dash/css/colors/megna-dark.css') }}" id="theme" rel="stylesheet">

    <link href="{{ asset('assets/select2/css/select2.css') }}" id="theme" rel="stylesheet">
    <link href="{{ asset('assets/toastr/toastr.css') }}" id="theme" rel="stylesheet">

    <link href="{!! asset('dash/plugins/datatables/dataTables.bootstrap4.min.css') !!}" rel="stylesheet">
    <link href="{{ asset('assets/bootstrap.daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet"
        type="text/css">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/button/css/buttons.dataTables.min.css') }}" />

    <link href="{{ asset('dash/plugins/bower_components/datatables/jquery.dataTables.min.css') }}" rel="stylesheet"
        type="text/css" />
</head>

<body class="fix-header">
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    <div id="wrapper">
        @include('layouts.nav')
        @include('layouts.sidebar')
        @yield('content')
       
        @include('modal.changepassword')
        <footer class="footer">
            <div class="container text-center">
                <small class="copyright">Powered by <a href="http://servilink.systems" target="_blank"> <img
                            src="{{ asset('img/logo.png') }}" width="20px" height="20px" alt="Servilink"
                            style=" max-width:80px; height: auto;"></a> Servilink</small>
                <div class="ftr-1"><i class="fa fa-copyright"></i> <?php echo date('Y'); ?>  Servilink Rights
                    Reserved.</div>
            </div>
            <!--//container-->
        </footer>
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="{{ asset('dash/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="{{ asset('dash/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>
    <!--Counter js -->
    <script src="{{ asset('dash/plugins/bower_components/waypoints/lib/jquery.waypoints.js') }}"></script>
    <script src="{{ asset('dash/plugins/bower_components/counterup/jquery.counterup.min.js') }}"></script>
    <!--slimscroll JavaScript -->
    <script src="{{ asset('dash/js/jquery.slimscroll.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('dash/js/waves.js') }}"></script>
    <!-- Vector map JavaScript -->
    <script src="{{ asset('dash/js/custom.min.js') }}"></script>
    <script src="{{ asset('dash/js/dashboard3.js') }}"></script>

    <script src="{{ asset('assets/select2/js/select2.js') }}"></script>

    <script src="{{ asset('assets/toastr/toastr.min.js') }}"></script>

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
    <!-- end - This is for export functionality only -->
    <!--Style Switcher -->
    <script src="{{ asset('dash/plugins/bower_components/styleswitcher/jQuery.style.switcher.js') }}"></script>
    <script>
        $(document).ready(function(e) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });
            $("#changepassword").on("show.bs.modal", function(e) {
                $("#passform").trigger("reset");
            });


            $('#passform').submit(function(e) {
                e.preventDefault();
                let form = $('#passform').serialize();
                $.ajax({
                    method: 'POST',
                    url: '/passwordchange',
                    data: form,
                    success: function(response) {
                        if (response.status == "ok") {
                            toastr.success(response.Message, {
                                timeOut: 5000
                            });

                        } else {
                            toastr.warning(response.Message, {
                                timeOut: 5000
                            });
                        }
                        $("#changepassword").modal('hide');
                    }
                });
            });

        });
    </script>

</body>

</html>
