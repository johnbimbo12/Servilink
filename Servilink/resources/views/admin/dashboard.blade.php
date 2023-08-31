@extends('layouts.manager')
@section('title', 'Dashboard')
@section('content')
    <style>
        @media (min-width: 1281px) {
  
          /* CSS */
           .amt{
              font-size:40px !important;
          }
          
          
        }
        
        /* 
          ##Device = Laptops, Desktops
          ##Screen = B/w 1025px to 1280px
        */
        
        @media (min-width: 1025px) and (max-width: 1280px) {
          
          /* CSS */
           .amt{
              font-size:40px !important;
          }
          
        }
        
        /* 
          ##Device = Tablets, Ipads (portrait)
          ##Screen = B/w 768px to 1024px
        */
        
        @media (min-width: 768px) and (max-width: 1024px) {
          
          /* CSS */
           .amt{
              font-size:30px !important;
          }
          
        }
        
        /* 
          ##Device = Tablets, Ipads (landscape)
          ##Screen = B/w 768px to 1024px
        */
        
        @media (min-width: 768px) and (max-width: 1024px) and (orientation: landscape) {
          
            .amt{
              font-size:30px !important;
          }
          
        }
        
        /* 
          ##Device = Low Resolution Tablets, Mobiles (Landscape)
          ##Screen = B/w 481px to 767px
        */
        
        @media (min-width: 481px) and (max-width: 767px) {
          
            .amt{
              font-size:30px !important;
          }
          
        }
        
        /* 
          ##Device = Most of the Smartphones Mobiles (Portrait)
          ##Screen = B/w 320px to 479px
        */
        
        @media (min-width: 320px) and (max-width: 480px) {
          
          /* CSS */
          .amt{
              font-size:30px !important;
          }
          
        }

    </style>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Administrator Dashboard</h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12" style="text-align: right;float: right;">
                    <div id="reportrange" class="pull-right" data-format="yyyy-mm-dd" data-from="" data-to=""
                        style="padding: 20px">
                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                        <span></span> <b class="caret"></b>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-4 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 8px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <ul class="list-inline">
                            <li><i class="icon-people text-info" style="font-size: 30px"></i></li>
                            <li><h2 style="font-weight: bolder">MANAGERS</h2></li>
                        </ul>
                        <ul class="list-inline">
                            <li class="text-right"><span class="counter amt">{{ $managers }}</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 8px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <ul class="list-inline">
                            <li><i class="icon-home text-info" style="font-size: 30px"></i></li>
                            <li><h2 style="font-weight: bolder">REGISTERED ESTATES</h2></li>
                        </ul>
                        <ul class="list-inline">
                            <li class="text-right"><span class="counter amt">{{ $estates }}</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 8px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                         <ul class="list-inline">
                            <li><i class=" mdi mdi-arrow-up fa-fw  text-success" style="font-size: 30px"></i></li>
                            <li><h2 style="font-weight: bolder">REVENUE</h2></li>
                        </ul>
                        <ul class="list-inline">
                            <li class="text-center"><span  class="amt"> ₦</span><span
                                    class="powervend amt">{{ $power }}</span></li>
                        </ul>
                      
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 8px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <ul class="list-inline">
                            <li><i class=" mdi mdi-lightbulb-on fa-fw  text-danger" style="font-size: 30px"></i></li>
                            <li><h2 style="font-weight: bolder">POWER VEND</h2></li>
                        </ul>
                        <ul class="list-inline">
                            <li class="text-center"><span  class="amt"> ₦</span><span
                                class="powervend amt">{{ $power }}</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 8px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                      
                        <ul class="list-inline">
                            <li><i class=" mdi mdi-water-pump fa-fw text-success" style="font-size: 30px"></i></li>
                            <li><h2 style="font-weight: bolder">WATER VEND</h2></li>
                        </ul>
                        <ul class="list-inline">
                            <li class="text-center"><span class="amt"> ₦</span><span
                                class="watervend amt">{{ $water }}</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 8px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">                        
                        <ul class="list-inline">
                            <li><i class=" mdi  mdi-arrow-down fa-fw  text-danger" style="font-size: 30px"></i></li>
                            <li><h2 style="font-weight: bolder">CREDIT (Sold)</h2></li>
                        </ul>
                        <ul class="list-inline">
                            <li class="text-center"><span class="amt"> ₦</span><span
                                class="creditsales amt">{{ $credit }}</span></li>
                        </ul>
                    </div>
                </div>


            </div>
            <div class="row">
                <div class="col-md-12 col-lg-6 col-sm-12">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <h3 class="box-title">Revenue Income </h3>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6 pull-right">
                                <div id="incomerange" class="pull-right" data-format="yyyy-mm-dd" data-from=""
                                    data-to="">
                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                    <span></span> <b class="caret"></b>
                                </div>
                            </div>
                        </div>

                        <div class="row sales-report">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <h2 id="revenuemonth">March 2017</h2>
                                <p>SALES REPORT</p>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6 ">
                                <h1 class="text-right text-success m-t-20"><span> ₦</span><span
                                        class="tRevenue">{{ $revenue }}</span></h1>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ESTATE NAME</th>
                                        <th>SERVICE</th>
                                        <th>DATE</th>
                                        <th>AMOUNT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($revenueincome as $income)
                                        <tr>
                                            <td class="txt-oflo">{{ $income->name }}</td>
                                            @if ($income->purchase_type == 0)
                                                <td><span class="label label-danger label-rouded">Power Purchase</span></td>
                                            @elseif ($income->purchase_type == 1)
                                                <td><span class="label label-info label-rouded">Water Purchase</span></td>
                                            @elseif ($income->purchase_type == 2)
                                                <td><span class="label label-success label-rouded">Service Fee</span></td>
                                            @endif

                                            <td class="txt-oflo">{{ $income->created_at }}</td>
                                            <td><span class="text-info">₦{{ $income->amount }}</span></td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            @if (count($revenueincome) == 0)
                                <div class="text-center"> No income yet</div>
                            @endif
                            <a href="{{ route('revenue') }}">Check all the sales</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 col-sm-12">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <h3 class="box-title">Recent Sales</h3>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6 pull-right">
                                <div id="salesrange" class="pull-right" data-format="yyyy-mm-dd" data-from=""
                                    data-to="">
                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                    <span></span> <b class="caret"></b>
                                </div>
                            </div>
                        </div>
                        <div class="row sales-report">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <h2 id="salemonth">March 2017</h2>
                                <p>SALES REPORT</p>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6 ">
                                <h1 class="text-right text-success m-t-20"><span> ₦</span><span
                                        class="tSales">{{ $tsales }}</span></h1>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>NAME</th>
                                        <th>SERVICE</th>
                                        <th>DATE</th>
                                        <th>AMOUNT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($utilitysale as $sale)
                                        <tr>
                                            <td class="txt-oflo">{{ $sale->name }}</td>
                                            @if ($sale->vend_utility == 0)
                                                <td><span class="label label-danger label-rouded">Power Purchase</span></td>
                                            @else
                                                <td><span class="label label-info label-rouded">Water Purchase</span></td>
                                            @endif

                                            <td class="txt-oflo">{{ $sale->created_at }}</td>
                                            <td><span class="text-info">₦{{ $sale->vend_value }}</span></td>
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                            @if (count($utilitysale) == 0)
                                <div class="text-center"> No sales yet</div>

                            @endif

                            <a href="{{ route('power.manage') }}">Check all the sales</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.container-fluid -->
        <footer class="footer text-center"><?php echo date('Y'); ?> &copy;
            Servilink. All
            Rights
            Reserved. </footer>
    </div>


    <script src="{{ asset('dash/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>

    <script>
        $(document).ready(function(e) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });

            $.ajax({
                method: "GET",
                url: "{{ route('wallet.balance') }}",
                success: function(msg) {
                    console.log(msg)
                },

            });


            function loadCardDetails(start, end, type) {
                $.ajax({
                    method: "GET",
                    url: "{{ route('admin.stat') }}",
                    data: {
                        start_date: start,
                        end_date: end
                    },
                    success: function(msg) {

                        if (type == 0) {
                            var tmeter = (msg.revenue)
                            var year = (msg.power)
                            var credit = (msg.credit)
                            var month = (msg.water)
                            $(".revenue").text(tmeter);
                            $(".powervend").text(year);
                            $(".watervend").text(month);
                            $(".creditsales").text(credit);
                        } else if (type == 1) {
                            $(".tRevenue").text(msg.revenue);
                        } else {
                            $(".tSales").text(msg.tsale);
                        }

                    },

                });
            }


            var today = moment().format('YYYY-MM-DD');
            var start = moment().startOf('month');
            var end = moment().endOf('month');
            $('#reportrange').val(start.format('YYYY-MM-DD') + " : " + end.format('YYYY-MM-DD'));
            $('#reportrange').attr("data-from", start.format('YYYY-MM-DD'));
            $('#reportrange').attr('data-to', end.format('YYYY-MM-DD'));
            $('#salesrange').val(start.format('YYYY-MM-DD') + " : " + end.format('YYYY-MM-DD'));
            $('#salesrange').attr("data-from", start.format('YYYY-MM-DD'));
            $('#salesrange').attr('data-to', end.format('YYYY-MM-DD'));

            $('#incomerange').val(start.format('YYYY-MM-DD') + " : " + end.format('YYYY-MM-DD'));
            $('#incomerange').attr("data-from", start.format('YYYY-MM-DD'));
            $('#incomerange').attr('data-to', end.format('YYYY-MM-DD'));
            var cb = function(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                $('#salesrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                $('#incomerange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                $('#salemonth').text(moment().format('MMMM, YYYY'));
                $('#revenuemonth').text(moment().format('MMMM, YYYY'));
            };

            cb(start, end);

            var optionSet = {
                startDate: start,
                endDate: end,
                opens: 'right',
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                        .endOf('month')
                    ]
                }
            };


            $('#reportrange').daterangepicker(optionSet, cb);
            $('#incomerange').daterangepicker(optionSet, cb);
            $('#salesrange').daterangepicker(optionSet, cb);


            $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
                $('#reportrange').attr("data-from", picker.startDate.format('YYYY-MM-DD'));
                $('#reportrange').attr('data-to', picker.endDate.format('YYYY-MM-DD'));
                loadCardDetails($("#reportrange").attr("data-from"), $("#reportrange").attr("data-to"), 0);
            });


            $('#incomerange').on('apply.daterangepicker', function(ev, picker) {
                $('#incomerange').attr("data-from", picker.startDate.format('YYYY-MM-DD'));
                $('#incomerange').attr('data-to', picker.endDate.format('YYYY-MM-DD'));
                loadCardDetails($("#incomerange").attr("data-from"), $("#incomerange").attr("data-to"), 1);
                var st = picker.startDate.format('MMMM, YYYY');
                var ed = picker.endDate.format('MMMM, YYYY')
                if (st == ed) {
                    $('#revenuemonth').text(st);
                } else {
                    $('#revenuemonth').text(st + " - " + ed);
                }


            });

            $('#salesrange').on('apply.daterangepicker', function(ev, picker) {
                $('#salesrange').attr("data-from", picker.startDate.format('YYYY-MM-DD'));
                $('#salesrange').attr('data-to', picker.endDate.format('YYYY-MM-DD'));

                loadCardDetails($("#salesrange").attr("data-from"), $("#salesrange").attr("data-to"), 2);
                var st = picker.startDate.format('MMMM, YYYY');
                var ed = picker.endDate.format('MMMM, YYYY')
                if (st == ed) {
                    $('#salemonth').text(st);
                } else {
                    $('#salemonth').text(st + " - " + ed);
                }

            });


        });
    </script>
@endsection
