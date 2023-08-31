@extends('layouts.user')
@section('title', 'Service Fee Management')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                    <h4 class="page-title">Service Fee Management</h4>
                </div>
            </div>
            @include('theme.flash-messages')
            <div class="row">

                <div class="col-lg-4 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Service Charge Fee </h3>
                        <ul class="list-inline  two-part">
                            <li><span>₦</span><span>{{ $servicefee }}</span>/Month</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Last Payment</h3>
                        <ul class="list-inline two-part">
                            <li style="width: 100% !important"><span>{{ $lastpayment }}</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Service Fee Due in <a href="#" data-toggle="modal"
                                data-target="#modal-chargepay" style="text-align: right; float: right;">Renew Now</a></h3>

                        <ul class="list-inline two-part">
                            <li> <span>{{ $rDays }}Days</span></li>

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
                                <div class="panel-heading">Transactions</div>
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
                            <table class="table table-hover" id="servicehistory">
                                <thead>
                                    <tr>
                                        <th style="width: 80px;">Transaction ID</th>
                                        <th style="width: 80px;">Amount</th>
                                        <th style="width: 80px;">No of Paid Month</th>
                                        <th style="width: 80px;">Due Date</th>
                                        <th style="width: 80px;">Payment Date</th>
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

    <div class="modal fade" id="modal-chargepay" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content"
                style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Service Fee Payment </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('payprocess') }}" enctype="multipart/form-data" id="">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="path" value="1">
                            <input type="text" name="meternumber" value="{{ auth::user()->estateuser->meternumber }}"
                                id="meterpan" hidden>
                            <input type="text" name="email" value="{{ auth::user()->email }}" hidden>
                            <input type="text" name="estateid" value="{{ auth::user()->estateuser->estate_id }}" hidden>
                            <input type="text" name="phonenumber" value="{{ auth::user()->estateuser->phonenumber }}"
                                hidden>
                            <div class="form-group col-md-12" data-validate="Purchase Amount">
                                <input id="nummonth" type="number"
                                    class="form-control @error('nummonth') is-invalid @enderror" name="nummonth" value="1"
                                    min="1" max="12" required placeholder=" Number of months" autocomplete="off">
                                @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <input type="text" hidden value="{{ $servicefee }}" id="fee">
                            <input type="text" id="scamount" name="scamount" value="{{ $servicefee }}" style="display: none">
                            <div class="form-group" style="font-size: 30px;margin-left:20px">
                                <span>₦</span><label id="totalamt">
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-lg btn-info" id="generate" type="submit">
                                Paid
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
            let serviceamount = parseInt($('#fee').val());
            serviceamount = (serviceamount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            $('#totalamt').html(serviceamount);
            $('#nummonth').on('input', function() {
                var months = parseInt($(this).val());
                let amount = parseInt($('#fee').val());
                if (months > 0) {
                    serviceamount = months * amount;
                    $('input[name=scamount]').val(serviceamount);
                    serviceamount = (serviceamount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                    $('#totalamt').html(serviceamount);
                }

            });

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

            $('#reportrange').on('show.daterangepicker', function() {

            });
            $('#reportrange').on('hide.daterangepicker', function() {

            });
            $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
                $('#reportrange').attr("data-from", picker.startDate.format('YYYY-MM-DD'));
                $('#reportrange').attr('data-to', picker.endDate.format('YYYY-MM-DD'));
                $('#reportrange span').html(picker.startDate.format('MMMM D, YYYY') + ' - ' + picker.endDate
                    .format('MMMM D, YYYY'));
                $('#servicehistory').DataTable().draw(true);
                tablereport.ajax.reload(null, false);
            });
            $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {

            });
            var tablereport = $("#servicehistory").DataTable({
                processing: true,
                "ordering": false,
                "ajax": {
                    "url": "{!! route('load.service') !!}",
                    "data": function(d) {
                        d.start_date = $("#reportrange").attr("data-from");
                        d.end_date = $("#reportrange").attr("data-to");
                    }

                },
                "pageLength": 50,
                dom: 'Blfrtip',
                buttons: [
                    'excel', 'pdf', 'print'
                ],

                columns: [{
                        data: "txref",
                        name: "txref",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform", "sorting_1");
                        }
                    },
                    {
                        data: "amount",
                        name: "amount",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform");
                        },
                        render: function(data, type, row) {
                            return (data);
                        },

                    },
                    {
                        data: "no_of_month",
                        name: "no_of_month",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform");
                        },
                        render: function(data, type, row) {
                            return (data);
                        },

                    },
                    {
                        data: "duedate",
                        name: "duedate",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform");
                        },

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





            // $('#buypower').submit(function(e) {
            //     e.preventDefault()
            //     let form = $('#buypower').serialize();
            //     $.ajax({
            //         method: 'POST',
            //         url: "{!! route('power.buy') !!}}",
            //         data: form,
            //         success: function(response) {
            //             if (response.status = "ok") {
            //                 $("#user")
            //                     .DataTable()
            //                     .draw(true);
            //                 tableuser.ajax.reload(null, false);
            //                 toastr.success('New user added', {
            //                     timeOut: 5000
            //                 });
            //             } else if (response.status == "info") {

            //                 toastr.info('Card exit', {
            //                     timeOut: 5000
            //                 });


            //             } else {
            //                 toastr.error('New user added', {
            //                     timeOut: 5000
            //                 });
            //             }

            //             $("#modal-add-user").modal('hide')
            //         }
            //     });
            // });


        });
    </script>
@endsection
