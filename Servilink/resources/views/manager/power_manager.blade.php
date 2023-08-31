@extends('layouts.manager')
@section('title', 'Power Management')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Power Management</h4>
                </div>

                <div class="col-lg-9 col-sm-6 col-md-6 col-xs-6">
                    <a href="#" data-toggle="modal" data-target="#modal-buypower"
                        class="btn btn-danger pull-right waves-effect waves-light">Send resident electricity Token</a>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Registered Meters</h3>
                        <ul class="list-inline two-part">
                            <li><span class="meter">0</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Year Vending</h3>
                        <ul class="list-inline  two-part">
                            <li><span> ₦</span><span class="yearvend">0.00</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Month Vending <span class="date" style="font-size: 10px"></h3>
                        <ul class="list-inline two-part">
                            <li> <span> ₦</span><span class="monthvend">0.00</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Vend Query <span class="datequery" style="font-size: 10px"></h3>
                        <ul class="list-inline two-part">
                            <li> <span> ₦</span><span class="vendquery">0.00</span></li>
                        </ul>
                    </div>
                </div>

            </div>
            @include('theme.flash-messages')
            <div class="row">
                <div class="col-md-12">
                    <div class="panel"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">

                        <div class="row ">
                            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                <div class="panel-heading">Vending Details</div>
                            </div>
                            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12" style="text-align: right;float: right;">
                                <div id="reportrange" class="pull-right" data-format="yyyy-mm-dd" data-from=""
                                    data-to="" style="padding: 20px">
                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                    <span></span> <b class="caret"></b>
                                </div>
                            </div>
                            <!-- /.col-lg-12 -->
                        </div>
                        <div class="table-responsive" style="padding-left: 10px;padding-right: 10px">
                            <table class="table table-hover" id="vendhistory">
                                <thead>
                                    <tr>
                                        <th style="width: 80px;">Resident Name</th>
                                        <th style="width: 80px;">Address</th>
                                        <th style="width: 80px;">Meter No.</th>
                                        <th style="width: 80px;">Transaction ID</th>
                                        <th style="width: 80px;">Amount (NGN)</th>
                                        <th style="width: 80px;">Unit (kWH)</th>
                                        <th style="width: 80px;">Vending Status</th>
                                        <th style="width: 80px;">Vend Channel</th>
                                        <th style="width: 80px;">Token</th>
                                        <th style="width: 80px;">Transaction Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="modal fade" id="modal-buypower" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content"
                    style="border-radius: 8px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Power Purchase </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: relative; top:-30px"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('purchaseunit') }}" enctype="multipart/form-data"
                            id="vendpower">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input id="meternumber" type="type"
                                        class="form-control meternumber  @error('meternumber') is-invalid @enderror"
                                        name="meternumber" value="" required placeholder="Enter meter number" autofocus
                                        autocomplete="off">
                                    @error('meternumber')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>


                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-lg btn-info" id="generate" type="submit">
                                    Vend
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div> {{-- Modal Body --}}

        </div>
        <!-- /.container-fluid -->
        <footer class="footer text-center"><?php echo date('Y'); ?> &copy;
            Hinge Systems. All
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

            $('#vendpower').submit(function(e) {
                toastr.success("Loading, Please wait !!!", {
                    timeOut: 5000
                });
                 $('#generate').attr({
                        'disabled': 'true'
                });

            });
            $("#modal-buypower").on('hide.bs.modal', function(){
                $('#generate').removeAttr('disabled');
            });

            $("#modal-buypower").on('show.bs.modal', function(){
                $('#generate').removeAttr('disabled');
            });

            $('.meternumber').blur(function() {
                $.ajax({
                    method: 'GET',
                    url: "{{ route('getmeter') }}",
                    data: {
                        meternumber: $(this).val()
                    },
                    success: function(response) {
                        console.log(response);
                        $('.email').val(response.email);
                        $('.phone').val(response.phone);
                    }
                });
            });

            function loadCardDetails() {
                $.ajax({
                    method: "GET",
                    url: "/mpowerstat",
                    data: {
                        start_date: $("#reportrange").attr("data-from"),
                        end_date: $("#reportrange").attr("data-to")
                    },
                    success: function(msg) {

                        var tmeter = (msg.meter)
                        var year = (msg.yearamt)
                        var query = (msg.query)
                        var month = (msg.monthamt)
                        $(".meter").text(tmeter);
                        $(".yearvend").text(year);
                        $(".vendquery").text(query);
                        $(".monthvend").text(month);


                    },

                });
            }

            var today = moment().format('YYYY-MM-DD');
            var start = moment().startOf('month');
            var end = moment().endOf('month');
            $(".date").text("( "+start.format('MMMM, YYYY')  + " )");
            $('#reportrange').val(start.format('YYYY-MM-DD') + " : " + end.format('YYYY-MM-DD'));
            $('#reportrange').attr("data-from", start.format('YYYY-MM-DD'));
            $('#reportrange').attr('data-to', end.format('YYYY-MM-DD'));
            var cb = function(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            };

            cb(start, end);
            loadCardDetails();
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
            $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
                $('#reportrange').attr("data-from", picker.startDate.format('YYYY-MM-DD'));
                $('#reportrange').attr('data-to', picker.endDate.format('YYYY-MM-DD'));
                $('#vendhistory').DataTable().draw(true);
                tablehistory.ajax.reload(null, false);
               
                loadCardDetails();
                var st = picker.startDate.format('MMMM, YYYY');
                var ed = picker.endDate.format('MMMM, YYYY')
                if (st == ed) {
                    $('.datequery').text("( " + st +" )");
                } else {
                    $('.datequery').text("( "+st + " - " + ed +" )");
                }
            });
         
            var tablehistory = $("#vendhistory").DataTable({
                processing: true,
                serverSide: true,
                "ordering": false,
                "ajax": {
                    "url": "/loadvendtransact",
                    "data": function(d) {
                        d.start_date = $("#reportrange").attr("data-from");
                        d.end_date = $("#reportrange").attr("data-to");
                    }
                },

                dom: 'Blfrtip',
                "pageLength": 50,
                buttons: [
                    'csv', 'excel', 'pdf',
                ],

                columns: [

                    {
                        data: "name",
                        name: "name",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform", "sorting_1");
                        }
                    },
                    {
                        data: "housenum",
                        name: "housenum",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform", "sorting_1");
                        }
                    },
                    
                    {
                        data: "meterPan",
                        name: "meterPan",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform", "sorting_1");
                        }
                    }, {
                        data: "txref",
                        name: "txref",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform", "sorting_1");
                        }
                    },
                    {
                        data: "vend_value",
                        name: "vend_value",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform");
                        },

                    },
                    {
                        data: "unitsActual",
                        name: "unitsActual",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform");
                        },

                    },


                    {
                        data: "verified",
                        name: "verified",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform");
                        },
                        render: function(data, type, row) {
                            if (data == 1) {
                                return "Verified";
                            } else {
                                return "Unverified";
                            }
                        },
                    },

                    {
                        data: "vend_channel",
                        name: "vend_channel",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform", "center");
                        },
                        render: function(data, type, row) {
                            if (data == 0) {
                                return "Resident";
                            } else if (data == 1) {
                                return "Manager";
                            } else {
                                return "Admin";
                            }
                        },
                    },

                    {
                        data: "token",
                        name: "token",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform", "center");
                        }
                    },
                    {
                        data: "transdate",
                        name: "transdate",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform", "center");
                        },

                    }
                ]
            });

        });
    </script>
@endsection
