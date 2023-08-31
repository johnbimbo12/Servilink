@extends('layouts.manager')
@section('title', 'Power Management')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Power Management</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="white-box">
                        <h3 class="box-title">Successfull Transactions</h3>
                        <ul class="list-inline two-part">
                            <li><span class="t_transact">0</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="white-box">
                        <h3 class="box-title">Total Purchase</h3>
                        <ul class="list-inline  two-part">
                            <li class="text-right"><span> ₦</span><span class="t_purchase">0</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="white-box">
                        <h3 class="box-title">This Month Purchase</h3>
                        <ul class="list-inline two-part">
                            <li class="text-right"><span> ₦</span><span class="t_month">0</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="white-box">
                        <h3 class="box-title">Meters</h3>
                        <ul class="list-inline two-part">
                            <li><span class="t_meter">0</span></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">

                        <div class="row ">
                            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                <div class="panel-heading">Transaction Details</div>
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
                                        <th style="width: 80px;">Meter No.</th>
                                        <th style="width: 80px;">Transaction ID</th>
                                        <th style="width: 80px;">Amount (NGN)</th>
                                        <th style="width: 80px;">Unit (kWH)</th>
                                        <th style="width: 80px;">Vending Status</th>
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
        <!-- /.container-fluid -->
        <footer class="footer text-center"><?php echo date('Y'); ?> &copy;
            Hinge Systems. All
            Rights
            Reserved. </footer>
    </div>

@endsection
<script src="{{ asset('dash/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>

<script>
    $(document).ready(function(e) {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });

        loadCardDetails();

        function NumberFormat(amount) {
            return amount.toLocaleString();
        }

        function loadCardDetails() {
            $.ajax({
                method: "GET",
                url: "/mpowerstat",
                success: function(msg) {

                    var tpurchase = (msg.t_purchase).toLocaleString();
                    var transact = msg.t_transact;
                    var meter = (msg.t_meter)
                    var month = (msg.t_month).toLocaleString();
                    $(".t_transact").text(transact);
                    $(".t_purchase").text(tpurchase);
                    $(".t_meter").text(meter);
                    $(".t_month").text(month);


                },

            });
        }

        var today = moment().format('YYYY-MM-DD');
        var start = moment().startOf('month');
        var end = moment().endOf('month');
        $('#reportrange').val(start.format('YYYY-MM-DD') + " : " + end.format('YYYY-MM-DD'));
        $('#reportrange').attr("data-from", start.format('YYYY-MM-DD'));
        $('#reportrange').attr('data-to', end.format('YYYY-MM-DD'));
        var cb = function(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        };
       
        cb(start, end);
        var optionSet = {
            startDate: moment(),
            endDate: moment(),
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

        $('#reportrange').on('show.daterangepicker', function() {

        });
        $('#reportrange').on('hide.daterangepicker', function() {

        });
        $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
            $('#reportrange').attr("data-from", picker.startDate.format('YYYY-MM-DD'));
            $('#reportrange').attr('data-to', picker.endDate.format('YYYY-MM-DD'));
            $('#vendhistory').DataTable().draw(true);
            tablehistory.ajax.reload(null, false);
        });
        $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {

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

            dom: '<lBf"bottom">rt<"top"pi><"clear">',
            buttons: [{
                    extend: 'excelHtml5',
                    footer: true
                },
                {
                    extend: 'csvHtml5',
                    footer: true
                },
                'print',
                {
                    extend: 'copyHtml5',
                    footer: true
                },

            ],

            columns: [{
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
