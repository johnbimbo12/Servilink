@extends('layouts.user')
@section('title', 'Water Management')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                    <h4 class="page-title">Water Management</h4>
                    <span>Meter Number: {{ $user->estateuser->meternumber }}</span>
                </div>
                <div class="col-lg-9 col-sm-6 col-md-6 col-xs-6">
                    <a href="#" data-toggle="modal" data-target="#modal-buypower"
                        class="btn btn-danger pull-right waves-effect waves-light">Buy Water Unit</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            @include('theme.flash-messages')
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Last Unit Purchase</h3>
                        <ul class="list-inline two-part">
                            <li><span id="lastunit">0.00</span>kHW</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">This Month Purchase</h3>
                        <ul class="list-inline  two-part">
                            <li><span>₦</span><span id="tpurchase">0.00</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Last purchase</h3>
                        <ul class="list-inline two-part">
                            <li><span>₦</span><span id="lpurchase">0.00</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Purchase On-Credit <a href="{{ route('paycredit') }}"
                                style="text-align: right; float: right;">Pay Now</a></h3>

                        <ul class="list-inline two-part">
                            <li> <span> ₦</span><span id="oncredit">0.00</span></li>

                        </ul>

                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">

                        <div class="row ">
                            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                <div class="panel-heading">Water </div>
                            </div>

                            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12" style="text-align: right;float: right;">
                                <div id="reportrange" class="pull-right" data-format="yyyy-mm-dd" data-from=""
                                    data-to="" style="padding: 20px">
                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                    <span></span> <b class="caret"></b>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive" style="padding-left: 10px;padding-right: 10px">
                            <table class="table table-hover" id="vendhistory">
                                <thead>
                                    <tr>
                                        <th style="width: 80px;">Transaction ID</th>
                                        <th style="width: 80px;">Amount</th>
                                        <th style="width: 80px;">Vend Value</th>
                                        <th style="width: 80px;">Unit(kWH)</th>
                                        <th style="width: 80px;">Payment Status</th>
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
    </div>

    <div class="modal fade" id="modal-buypower" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content"
                style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Power Purchase </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('purchaseunit') }}" enctype="multipart/form-data" id="">
                        @csrf
                        <div class="row">
                            <input type="text" name="meternumber" value="{{ auth::user()->estateuser->meternumber }}"
                                id="meterpan" hidden>

                            <input type="text" name="name" value="{{ auth::user()->name }}" hidden>

                            <input type="text" name="email" value="{{ auth::user()->email }}" hidden>
                            <input type="text" name="phone" value="{{ auth::user()->estateuser->phonenumber }}" hidden>
                            <input type="text" name="path" value="2" hidden>
                            <div class="form-group col-md-12">
                                <select name="paytype" style="height: 50px; font-size: large;" id="paytype"
                                    class=" form-control @error('paytype') is-invalid @enderror" required>
                                    <option value="">Select purchase option</option>
                                    <option value="1">Pay</option>
                                    <option value="2">On-credit</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12" data-validate="Purchase Amount">
                                <input id="amount" type="number" class="form-control  @error('amount') is-invalid @enderror"
                                    name="amount" value="" required placeholder="Purchase amount" autofocus
                                    autocomplete="off">
                                @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-lg btn-info" id="generate" type="submit">
                                Buy
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div> {{-- Modal Body --}}

    </div>
    <script type="text/javascript" src=" {!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>

    <script>
        $(document).ready(function(e) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });

            // loadPowerDetails();

            // const formatToCurrency = amount => {
            //     return amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
            // };

            // function NumberFormat(amount) {
            //     return amount.toLocaleString();
            // }

            // function loadPowerDetails() {
            //     $.ajax({
            //         method: "GET",
            //         url: "{{ route('power.stat') }}",
            //         success: function(msg) {
            //             var tpurchase = (msg.alltimepurchse).toLocaleString();
            //             var lastunit = msg.lastvending.unitsActual;
            //             var lpurchase = (msg.lastvending.amount).toLocaleString();
            //             var creditpurchase = msg.creditpurchase.toLocaleString();

            //             $("#lastunit").text(lastunit);
            //             $("#tpurchase").text(tpurchase);
            //             $("#lpurchase").text(lpurchase);
            //             $("#oncredit").text(creditpurchase);
            //         },

            //     });
            // }

            // var today = moment().format('YYYY-MM-DD');
            // var start = moment().startOf('month');
            // var end = moment().endOf('month');
            // $('#reportrange').val(start.format('YYYY-MM-DD') + " : " + end.format('YYYY-MM-DD'));
            // $('#reportrange').attr("data-from", start.format('YYYY-MM-DD'));
            // $('#reportrange').attr('data-to', end.format('YYYY-MM-DD'));
            // var cb = function(start, end) {
            //     $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            // };

            // cb(start, end);
            // var optionSet = {
            //     startDate: moment(),
            //     endDate: end,
            //     opens: 'right',
            //     ranges: {
            //         'Today': [moment(), moment()],
            //         'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            //         'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            //         'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            //         'This Month': [moment().startOf('month'), moment().endOf('month')],
            //         'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
            //             .endOf('month')
            //         ]
            //     }
            // };


            // $('#reportrange').daterangepicker(optionSet, cb);

            // $('#reportrange').on('show.daterangepicker', function() {

            // });
            // $('#reportrange').on('hide.daterangepicker', function() {

            // });
            // $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
            //     $('#reportrange').attr("data-from", picker.startDate.format('YYYY-MM-DD'));
            //     $('#reportrange').attr('data-to', picker.endDate.format('YYYY-MM-DD'));
            //     $('#reportrange span').html(picker.startDate.format('MMMM D, YYYY') + ' - ' + picker.endDate
            //         .format('MMMM D, YYYY'));
            //     $('#vendhistory').DataTable().draw(true);
            //     tablereport.ajax.reload(null, false);
            // });
            // $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {

            // });
            // var tablereport = $("#vendhistory").DataTable({
            //     processing: true,
            //     "ordering": false,
            //     "ajax": {
            //         "url": "{!! route('power.details') !!}",
            //         "data": function(d) {
            //             d.start_date = $("#reportrange").attr("data-from");
            //             d.end_date = $("#reportrange").attr("data-to");
            //         }

            //     },
            //     "pageLength": 50,
            //     dom: 'Blfrtip',
            //     buttons: [
            //         'excel', 'pdf', 'print'
            //     ],

            //     columns: [{
            //             data: "txref",
            //             name: "txref",
            //             createdCell: function(td, cellData, rowData, row, col) {
            //                 $(td).css("text-transform", "sorting_1");
            //             }
            //         },
            //         {
            //             data: "amount",
            //             name: "amount",
            //             createdCell: function(td, cellData, rowData, row, col) {
            //                 $(td).css("text-transform");
            //             },
            //             render: function(data, type, row) {
            //                 return (data);
            //             },

            //         },
            //         {
            //             data: "vend_value",
            //             name: "vend_value",
            //             createdCell: function(td, cellData, rowData, row, col) {
            //                 $(td).css("text-transform");
            //             },
            //             render: function(data, type, row) {
            //                 return (data);
            //             },

            //         },
            //         {
            //             data: "unitsActual",
            //             name: "unitsActual",
            //             createdCell: function(td, cellData, rowData, row, col) {
            //                 $(td).css("text-transform");
            //             },

            //         },
            //         {
            //             data: "purchase_type",
            //             name: "purchase_type",
            //             createdCell: function(td, cellData, rowData, row, col) {
            //                 $(td).css("text-transform");
            //             },
            //             render: function(data, type, row) {
            //                 if (data == 0) {
            //                     return "Full Payment";
            //                 } else {
            //                     return "On Credit";
            //                 }
            //             },
            //         },

            //         {
            //             data: "verified",
            //             name: "verified",
            //             createdCell: function(td, cellData, rowData, row, col) {
            //                 $(td).css("text-transform");
            //             },
            //             render: function(data, type, row) {
            //                 if (data == 1) {
            //                     return "Verified";
            //                 } else {
            //                     return "Unverified";
            //                 }
            //             },
            //         },

            //         {
            //             data: "token",
            //             name: "token",
            //             createdCell: function(td, cellData, rowData, row, col) {
            //                 $(td).css("text-transform", "center");
            //             }
            //         },
            //         {
            //             data: "transdate",
            //             name: "transdate",
            //             createdCell: function(td, cellData, rowData, row, col) {
            //                 $(td).css("text-transform", "center");
            //             },

            //         }
            //     ]
            // });

        });
    </script>
@endsection
