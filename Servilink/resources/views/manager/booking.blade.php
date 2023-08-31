@extends('layouts.manager')
@section('title', 'Booking')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Venue Bookings</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Current Booking</h3>
                        <ul class="list-inline two-part">
                            <li><span class="t_venue">{{$cbooking}}</span></li>
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
                                <div class="panel-heading">List</div>
                            </div>
                        </div>
                        <div class="table-responsive" style="padding-left: 10px;padding-right: 10px">
                            <table class="table table-hover" id="bookinglist">
                                <thead>
                                    <tr>
                                        <th style="width: 150px;">Resident Name</th>
                                        <th>Venue</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Amount</th>
                                        <th>Booked Date</th>
                                        <th>Status</th>
                                        <th style="width: 50px;">Action</th>
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
        <footer class="footer text-center"><?php echo date('Y'); ?> &copy;
            Hinge Systems. All
            Rights
            Reserved. </footer>
    </div>

    <script src="{{ asset('dash/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <div class="modal fade" id="modal-booking-details" role="dialog" data-backdrop="static" data-keyboard="false"
        aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header" style="border:none">
                    <div class="col-12">
                        <h4 class="modal-title" id="myModalLabel">Booking Details</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="position: relative; top:-30px"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <div class="modal-body">                     
                        <div>
                            <h4>Payer's Name: <span id="residentname"></span></h4>
                            <h5>Email Address: <span id="email"></span></h5>
                            <h5>Phone Number: <span id="phone"></span></h5>
                            <h5>Venue:  <span id="venuename"></span></h5>
                            <h5>Reserve Date:  <span id="booked_date"></span></h5>
                            <h5>Amount Paid:  NGN<span id="amount"></span></h5>
                            <h5>Details: <span id="description"></span></h5>
                            <h5>Status: <span id="status"></span></h5> 
                  
                    </div>
                </div>
            </div>
        </div> {{-- Modal Body --}}
    </div>
    <script>
        $(document).ready(function(e) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });

            $(document).on("click", ".show", function(e) {
               var id = $(this).attr("data-id");
                $.ajax({
                    method: 'GET',
                    url: "{{ route('show.booking') }}",
                    data: {
                        id: id,
                    },
                    success: function(response) {
                        var data = response;
                        $('.modal-body  #residentname').text(data.name);
                        $('.modal-body  #venuename').text(data.venue);
                        $('.modal-body  #email').text(data.email);
                        $('.modal-body  #phone').text(data.phonenumber);
                        $('.modal-body  #booked_date').text(data.booking_date);
                        $('.modal-body  #amount').text(data.cost);
                        $('.modal-body  #description').text(data.description);  
                        if(data.status ==1){
                            $('.modal-body  #status').text("Used");  
                        }else{
                            $('.modal-body  #status').text("Not Used");   
                        }
                                            
                        $("#modal-booking-details").modal('show')
                    }
                });
            });


            var bookings = $("#bookinglist").DataTable({
                processing: true,
                serverSide: true,
                "ordering": false,
                "ajax": {
                    "url": '{{ route('index.booking') }}',

                },
                dom: 'Blfrtip',
                "pageLength": 50,
                buttons: [
                    'csv', 'excel', 'pdf',
                ],

                columns: [{
                        data: "name",
                        name: "name",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform", "sorting_1");
                        }
                    },

                    {
                        data: "venue",
                        name: "venue",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform", "sorting_1");
                        }
                    },
                    {
                        data: "email",
                        name: "email",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform");
                        },

                    },
                    {
                        data: "phonenumber",
                        name: "phonenumber",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform");
                        },

                    },
                    {
                        data: "cost",
                        name: "cost",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform");
                        },

                    },
                    {
                        data: "booking_date",
                        name: "booking_date",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform");
                        },

                    },
                    {
                        data: "status",
                        name: "status",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform", "center");
                        },
                            render: function(data, type, row) {
                            if (data == 0) {
                                return "Not Used";
                            } 
                            else if (data == 1) {
                                return "Expire";
                            }
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
