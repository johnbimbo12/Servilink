
<?php $__env->startSection('title', "Visitor's Search"); ?>
<?php $__env->startSection('content'); ?>
    <div style="margin-left:10%; margin-right: 10%">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Visitor's Database</h4>
                </div>

            </div>
            <div class="row">
                <div class="form-group col-md-9">
                    <input id="query" type="text" class="form-control " name="query"
                        placeholder="Search resident by name, email, phonenumber, meternumber or by access token" autocomplete="off">

                </div>
              <input type="text" hidden value="" name="userid" id="userid">
                <input type="text" hidden value="0" name="token" id="token">
                <div class="form-group col-md-3">
                    <button class="btn btn-info" id="search" style="float: right">
                        Search
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel"
                        style="border-radius: 8px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">

                        <div class="row ">
                            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                <div class="panel-heading">Visiting Details</div>
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
                        <div class="table-responsive">
                            <table class="table table-hover" id="visithistory">
                                <thead>
                                    <tr>
                                        <th>Resident Name</th>
                                        <th>House Number</th>
                                        <th>Estate</th>
                                        <th>Phone Number</th>
                                        <th>Entry Set Time</th>
                                        <th>Valid Period</th>
                                         <th>Access Code</th>
                                        <th>Entry Status</th>
                                        <th>Exit Status</th>
                                        <th>Request Time</th>
                                        <th>Exit Time</th>
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
    <script src="<?php echo e(asset('dash/plugins/bower_components/jquery/dist/jquery.min.js')); ?>"></script>

    <script>
        $(document).ready(function(e) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });

            $(document).on("click", "#search", function(e) {
                $('#search').text('Searching...');
                var query = $('#query').val();
                if (query == "0") {
                    toastr.info("Enter search parameter", {
                        timeOut: 5000
                    });

                    return;
                }
                $.ajax({
                    method: 'GET',
                    url: "<?php echo e(route('visitor.search')); ?>",
                    data: {
                        queryval: query
                    },
                    success: function(response) {
                        if (response.status == false) {
                            toastr.info("No visting history found for search user", {
                                timeOut: 5000
                            });
                        } else {
                            $('#userid').val(response.userid);
                             $('#token').val(response.token);
                            $('#visithistory').DataTable().draw(true);
                            tablehistory.ajax.reload(null, false);
                        }

                        $('#search').text('Search');
                    }
                });
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
                $('#visithistory').DataTable().draw(true);
                tablehistory.ajax.reload(null, false);
            });
            $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {

            });


            var tablehistory = $("#visithistory").DataTable({
                processing: true,
                serverSide: true,
                "ordering": false,
                "ajax": {
                    "url": "<?php echo e(route('visitor.data')); ?>",
                    "data": function(d) {
                        d.start_date = $("#reportrange").attr("data-from");
                        d.end_date = $("#reportrange").attr("data-to");
                        d.queryval =  $('#userid').val();
                         d.token = $('#token').val();
                    }
                },

                dom: 'Blfrtip',
                "pageLength": 50,
                buttons: [
                    'csv', 'excel', 'pdf'
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
                            $(td).css("text-transform");
                        }
                    },
                    {
                        data: "estate",
                        name: "estate",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform");
                        }
                    },
                    {
                        data: "phone",
                        name: "phone",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform");
                        }
                    },
                    {
                        data: "entry_time",
                        name: "entry_time",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform");
                        }
                    },
                    {
                        data: "valid_period",
                        name: "valid_period",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform");
                        },

                    },
                     {
                        data: "visiting_token",
                        name: "visiting_token",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform");
                        },

                    },
                    {
                        data: "entry_status",
                        name: "entry_status",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform");
                        },
                        render: function(data, type, row) {
                            if (data == 0) {
                                return "Not Yet";
                            } else {
                                return "In";
                            }
                        }

                    },
                    {
                        data: "exit_status",
                        name: "exit_status",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform");
                        },
                        render: function(data, type, row) {
                            if (data == 0) {
                                return "Not Yet";
                            } else {
                                return "Out";
                            }
                        },

                    },
                    {
                        data: "gen_time",
                        name: "gen_time",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform");
                        }
                    },
                    {
                        data: "exit_time",
                        name: "exit_time",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform");
                        }
                    }
                ]
            });

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ocqv5p3q51h2/Servilink/resources/views/visitors_search.blade.php ENDPATH**/ ?>