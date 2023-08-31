@extends('layouts.manager')
@section('title', 'Service Fee Management')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                    <h4 class="page-title">Service Fee Management</h4>
                </div>

                <div class="col-lg-9 col-sm-6 col-md-6 col-xs-6">
                    <a href="#" data-toggle="modal" data-target="#modal-servicefee"
                        class="btn btn-danger pull-right waves-effect waves-light">Update Service Fee</a>
                </div>
            </div>


            @include('theme.flash-messages')
            <div class="row">

                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title mname">{{ $mName }} Pay In </h3>
                        <ul class="list-inline  two-part">
                            <li><span>₦</span><span class="mpay">{{ $mPayment }}</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title mnamer">{{ $mName }} Paid Resident</h3>
                        <ul class="list-inline two-part">
                            <li><span class="paidnum">{{ $paidnum }}</span></li>
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
                                <div class="panel-heading">Service Charge Transactions</div>
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
                                        <th>Resident Name</th>
                                        <th>House Address</th>
                                        <th>Transaction ID</th>
                                        <th>Amount</th>
                                        <th>No of Paid Month</th>
                                        <th>Due Date</th>
                                        <th>Transaction Date</th>
                                        
                                        <th>Action</th>
                                     
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
    <div class="modal fade" id="modal-servicefee" data-backdrop="static" data-keyboard="false" role="dialog"
        aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content"
                style="border-radius: 8px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Pay Service Fee</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="position: relative; top:-30px"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-9">
                            <input id="query" type="text"
                            class="form-control " name="query"
                           placeholder="Search resident by name, email, phonenumber, meternumber" autocomplete="off">
                     
                        </div>
                        <div class="form-group col-md-3">
                            <button class="btn btn-info" id="search" style="float: right">
                                Search
                            </button>
                        </div>
                    </div>
                  
                    <form method="POST" action="{{ route('pay.service') }}" enctype="multipart/form-data" id="payfee">
                        @csrf
                        <input type="text" name="meternum" value="1" class="meternum" hidden>
                        <input type="text" name="path" value="2" hidden>
                        <input type="text" name="paytype" value="2" hidden>
                        <div class="row">
                           
                            <div class="form-group col-md-6">
                                <label for="">Name</label>
                                <input id="name" type="text" class="form-control name" name="name" value="" readonly
                                  >
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Email Address</label>
                                <input id="email" type="text"
                                    class="form-control email  @error('email') is-invalid @enderror" name="email" value=""
                                    readonly >
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Phone number</label>
                                <input id="phone" type="number"
                                    class="form-control phone  @error('phone') is-invalid @enderror" name="phone" value=""
                                  readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">House Number</label>
                                <input id="housenum" type="text" class="form-control housenum" name="housenum" value=""
                                   readonly>
                            </div>
                            <div class="form-group col-md-12">
                                
                                <label for="">Last Pay Date</label>
                                <input id="expdate" type="text" class="form-control expdate" name="expdate" value=""
                                   readonly>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="">Number of months paid</label>
                                <input id="nummonth" type="number"
                                    class="form-control @error('nummonth') is-invalid @enderror" name="nummonth" value="1"
                                    min="1" required placeholder=" Number of months" autocomplete="off">
                            </div>
                            <input id="paidamt" type="text" hidden name="paidamt" value="">
                            <input class="servicefee" type="text" hidden value="">
                            <div class="form-group col-md-12">
                                <label for="">Amount paid</label>
                                <input id="cost" type="text" class="form-control" value=""
                                   readonly>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-lg btn-info" type="submit">
                                Update
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div> {{-- Modal Body --}}

    </div>
      <div class="modal fade" id="modal-update-date" role="dialog" data-backdrop="static" data-keyboard="false"
        aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-12">
                        <h4 class="modal-title" id="myModalLabel">Update Service Fee Due Date </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="position: relative; top:-30px"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" enctype="multipart/form-data" id="updatedate">
                        @csrf
                        <input type="hidden" value="" name="id" id="id">
                        <div class="row">
                            <div>                              
                                <div id="ispaid">
                                    <div class="form-group col-md-12">
                                        <label class="label-checkbox100" for="payday">
                                            Renewal date
                                        </label>
                                        <input id="payday" class="form-control" type="date" name="paymentdate">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-lg btn-info" id="updatedate" type="submit">
                                Update
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

            $('#nummonth').on('input', function() {
                var months = parseInt($(this).val());
                let amount = parseInt($('.servicefee').val());
                if (months > 0) {
                    let serviceamount = months * amount;
                    $('#paidamt').val(serviceamount);
                    serviceamount = (serviceamount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                    $('#cost').val('NGN ' + serviceamount);
                }
    
            });

             $("#modal-servicefee").on("show.bs.modal", function(e) {
                  $("#payfee").trigger("reset");
            });
               $("#modal-update-date").on("show.bs.modal", function(e) {
                var id = $(e.relatedTarget).data('id');
                $(".modal-body #id").val(id);
            });

            $('#updatedate').submit(function(e) {
                e.preventDefault()
                let form = $('#updatedate').serialize();
                $.ajax({
                    method: 'POST',
                    url: "{{route('service.update')}}",
                    data: form,
                    success: function(response) {
                        if (response.status = "ok") {
                            $("#servicehistory")
                                .DataTable()
                                .draw(true);
                            tablereport.ajax.reload(null, false);
                        }
                        toastr.success(response.msg, {
                            timeOut: 5000
                        });
                        $("#modal-update-date").modal('hide')
                    }
                });
            });




            $(document).on("click", "#search", function(e) {
                $('#search').text('Searching...');
              
                var query = $('#query').val();
                console.log(query);
                if (query == "0") {
                    toastr.info("Ener search parameter", {
                        timeOut: 5000
                    });

                    return;
                }
                $.ajax({
                    method: 'GET',
                    url: "{{ route('get.resident') }}",
                    data: {
                        queryval:query
                    },
                    success: function(response) {
                     
                        if (response.status == "ok") {
                            var data = response.data;
                            $('.email').val(data.email);
                            $('.phone').val(data.phonenumber);
                            $('.name').val(data.name);
                            $('.housenum').val(data.housenum);
                            $('.expdate').val(data.lastpayday);
                            $('.meternum').val(data.meternumber);
                            $('.servicefee').val(data.servicefee);
                            $('#cost').val(data.servicefee);
                            $('#paidamt').val(data.servicefee);
                            $('#nummonth').val(1);
                        } else {
                            toastr.info("Residence not found, kindly cross check!!!", {
                                timeOut: 5000
                            });
                        }
                        $('#search').text('Search');
                    }
                });
            });

         
            function NumberFormat(amount) {
                return amount.toLocaleString();
            }

            function loadCardDetails() {
                $.ajax({
                    method: "GET",
                    url: "{{ route('service.stat') }}",
                    data: {
                        start_date: $("#reportrange").attr("data-from"),
                        end_date: $("#reportrange").attr("data-to")
                    },
                    success: function(msg) {
                        var mpay = (msg.mPayment);
                        var paidnum = msg.paidnum;
                        $(".mpay").text(mpay);
                        $(".paidnum").text(paidnum);
                        $(".mname").text(msg.mName + " Pay In");
                        $(".mnamer").text(msg.mName + " Paid Resident");
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
                loadCardDetails();
            });
            $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {

            });
            var tablereport = $("#servicehistory").DataTable({
                processing: true,
                "ordering": false,
                "ajax": {
                    "url": "{!! route('service.transaction') !!}",
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

                    },
                    {
                        data: "action",
                        name: "action",
                        orderable: false,
                        searchable: false
                    }


                ]
            });
        });
    </script>
@endsection
