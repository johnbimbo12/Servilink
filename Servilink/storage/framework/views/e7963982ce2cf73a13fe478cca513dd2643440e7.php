
<?php $__env->startSection('title', 'Revenue Management'); ?>
<?php $__env->startSection('content'); ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Revenue Management</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 8px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Total Income</h3>
                        <ul class="list-inline  two-part">
                            <li><span> ₦</span><span class="tincome"><?php echo e($tincome); ?></span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 8px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">This Month</h3>
                        <ul class="list-inline two-part">
                            <li><span> ₦</span><span class="tmonth"><?php echo e($tmonth); ?></span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 8px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">This Week</h3>
                        <ul class="list-inline two-part">
                            <li><span> ₦</span><span class="tweek"><?php echo e($tweek); ?></span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 8px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Revenue <span class="date" style="font-size: 10px"></span></h3>
                        <ul class="list-inline two-part">
                            <li><span> ₦</span><span class="rquery">0</span></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel"
                        style="border-radius: 8px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">

                        <div class="row ">
                            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                <div class="panel-heading">Revenue Details</div>
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
                            <table class="table table-hover" id="paymenthistory">
                                <thead>
                                    <tr>
                                        <th style="width: 80px;">Payer's Name</th>
                                        <th style="width: 80px;">Estate</th>
                                        <th style="width: 80px;">Transaction ID</th>
                                        <th style="width: 80px;">Amount (NGN)</th>
                                        <th style="width: 80px;">Service Category</th>
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
            Servilink. All
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

            loadCardDetails();

            function NumberFormat(amount) {
                return amount.toLocaleString();
            }

            function loadCardDetails() {
                $.ajax({
                    method: "GET",
                    url: "<?php echo e(route('stat.revenue')); ?>",
                    data: {
                        start_date: $("#reportrange").attr("data-from"),
                        end_date: $("#reportrange").attr("data-to")
                    },
                    success: function(msg) {
                        $(".rquery").text(msg.rquery);
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
                $(".date").text("( "+start.format('MMMM, YYYY')  + " )");
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
            $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
                $('#reportrange').attr("data-from", picker.startDate.format('YYYY-MM-DD'));
                $('#reportrange').attr('data-to', picker.endDate.format('YYYY-MM-DD'));
                $('#paymenthistory').DataTable().draw(true);
                tablehistory.ajax.reload(null, false);
                loadCardDetails();
                var st = picker.startDate.format('MMMM, YYYY');
                var ed = picker.endDate.format('MMMM, YYYY')
                if (st == ed) {
                    $('.date').text("( " + st +" )");
                } else {
                    $('.date').text("( "+st + " - " + ed +" )");
                }
            });
          


            var tablehistory = $("#paymenthistory").DataTable({
                processing: true,
                serverSide: true,
                "ordering": false,
                "ajax": {
                    "url": "<?php echo e(route('revenue.load')); ?>",
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
                        data: "payer",
                        name: "payer",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform", "sorting_1");
                        }
                    },
                    
                    {
                        data: "estate",
                        name: "estate",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform");
                        },

                    }, {
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

                    },
                    {
                        data: "purchase_type",
                        name: "purchase_type",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform");
                        },
                        render: function(data, type, row) {
                            if (data == 0) {
                                return "Power";
                            } else if (data == 1) {
                                return "Water";
                            } else if (data == 2) {
                                return "Service Charge";
                            } else if (data == 3) {
                                return "credit";
                            }

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

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.manager', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ocqv5p3q51h2/Servilink/resources/views/admin/revenue_manager.blade.php ENDPATH**/ ?>