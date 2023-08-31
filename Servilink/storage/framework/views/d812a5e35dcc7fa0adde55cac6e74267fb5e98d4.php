<?php $__env->startSection('title', "Visitor's Management"); ?>
<?php $__env->startSection('content'); ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Visitor's Management</h4>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Today's Request</h3>
                        <ul class="list-inline two-part">
                            <li><span class="tRequest"><?php echo e($tRequest); ?></span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Used Access Code</h3>
                        <ul class="list-inline  two-part">
                            <li><span class="usedcode"><?php echo e($usedKey); ?></span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Unused Access Code</h3>
                        <ul class="list-inline two-part">
                            <li><span class="unusedcode"><?php echo e($unusedKey); ?></span></li>
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
                        <div class="table-responsive" style="padding-left: 10px;padding-right: 10px">
                            <table class="table table-hover" id="visithistory">
                                <thead>
                                    <tr>
                                        <th>Resident Name</th>
                                        <th>Visitor's Name</th>
                                        <th>Visitor Number</th>
                                        <th>Entry Date</th>
                                        <th>Entry Time</th>
                                        <th>Entry Status</th>
                                        <th>Valid Period</th>
                                        <th>Access Code</th>
                                        <th>Request Time</th>
                                        <th>Exit Status</th>
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
        <!-- /.container-fluid -->
        <footer class="footer text-center"><?php echo date('Y'); ?> &copy;
            Hinge Systems. All
            Rights
            Reserved. </footer>
    </div>
    <script src="<?php echo e(asset('dash/plugins/bower_components/jquery/dist/jquery.min.js')); ?>"></script>

    <script>
        $(document).ready(function(e) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
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
                $('#vendhistory').DataTable().draw(true);
                tablehistory.ajax.reload(null, false);
            });
            $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {

            });


            var tablehistory = $("#visithistory").DataTable({
                processing: true,
                serverSide: true,
                "ordering": false,
                "ajax": {
                    "url": "<?php echo e(route('get.visitors')); ?>",
                    "data": function(d) {
                        d.start_date = $("#reportrange").attr("data-from");
                        d.end_date = $("#reportrange").attr("data-to");
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
                        data: "visitor_name",
                        name: "visitor_name",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform", "sorting_1");
                        }
                    },
                    {
                        data: "visitornumber",
                        name: "visitornumber",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform", "sorting_1");
                        }
                    },
                    {
                        data: "entry_date",
                        name: "entry_date",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform");
                        }
                    }
                    ,
                     {
                        data: "entry_time",
                        name: "entry_time",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform");
                        }
                    }
                    ,
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
                        data: "valid_period",
                        name: "valid_period",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform");
                        },

                    }
                    ,
                        {
                        data: "visiting_token",
                        name: "visiting_token",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform");
                        },

                    }
                    ,
                    {
                        data: "gen_time",
                        name: "gen_time",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform");
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

<?php echo $__env->make('layouts.manager', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ocqv5p3q51h2/Servilink/resources/views/manager/visitor_manager.blade.php ENDPATH**/ ?>