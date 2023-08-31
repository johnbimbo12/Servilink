<?php $__env->startSection('title', 'Water Management'); ?>
<?php $__env->startSection('content'); ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Water Management</h4>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius:8px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Registered Meters</h3>
                        <ul class="list-inline two-part">
                            <li><span class="meter">0</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 8px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Year Income</h3>
                        <ul class="list-inline  two-part">
                            <li><span> ₦</span><span class="yearvend">0.00</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius:8px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Month Vending <span class="date" style="font-size: 10px"></h3>
                        <ul class="list-inline two-part">
                            <li> <span> ₦</span><span class="oncredit">0.00</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius:8px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Select Period Income</h3>
                        <ul class="list-inline two-part">
                            <li> <span> ₦</span><span class="monthvend">0.00</span></li>
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
                                        <th style="width: 80px;">Meter No.</th>
                                        <th style="width: 80px;">Transaction ID</th>
                                        <th style="width: 80px;">Amount (NGN)</th>
                                        <th style="width: 80px;">Unit (kWH)</th>
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

        

            function NumberFormat(amount) {
                return amount.toLocaleString();
            }

            // function loadCardDetails() {
            //     $.ajax({
            //         method: "GET",
            //         url: "/mpowerstat",
            //         data:{
            //             start_date : $("#reportrange").attr("data-from"),
            //             end_date : $("#reportrange").attr("data-to")
            //         },
            //         success: function(msg) {

            //             var tmeter = (msg.meter)
            //             var year = (msg.yearamt).toLocaleString();
            //             var credit = (msg.credit).toLocaleString();
            //             var month = (msg.monthamt).toLocaleString();
            //             $(".meter").text(tmeter);
            //             $(".yearvend").text(year);
            //             $(".monthvend").text(month);
            //             $(".oncredit").text(credit);


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

            cb(start, end);
            loadCardDetails();
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
                loadCardDetails();
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

                dom: 'Blfrtip',
                "pageLength": 50,
                buttons: [
                    'csv', 'excel', 'pdf',
                ],

                // columns: [{
                //         data: "meterPan",
                //         name: "meterPan",
                //         createdCell: function(td, cellData, rowData, row, col) {
                //             $(td).css("text-transform", "sorting_1");
                //         }
                //     }, {
                //         data: "txref",
                //         name: "txref",
                //         createdCell: function(td, cellData, rowData, row, col) {
                //             $(td).css("text-transform", "sorting_1");
                //         }
                //     },
                //     {
                //         data: "vend_value",
                //         name: "vend_value",
                //         createdCell: function(td, cellData, rowData, row, col) {
                //             $(td).css("text-transform");
                //         },

                //     },
                //     {
                //         data: "unitsActual",
                //         name: "unitsActual",
                //         createdCell: function(td, cellData, rowData, row, col) {
                //             $(td).css("text-transform");
                //         },

                //     },


                //     {
                //         data: "verified",
                //         name: "verified",
                //         createdCell: function(td, cellData, rowData, row, col) {
                //             $(td).css("text-transform");
                //         },
                //         render: function(data, type, row) {
                //             if (data == 1) {
                //                 return "Verified";
                //             } else {
                //                 return "Unverified";
                //             }
                //         },
                //     },

                //     {
                //         data: "token",
                //         name: "token",
                //         createdCell: function(td, cellData, rowData, row, col) {
                //             $(td).css("text-transform", "center");
                //         }
                //     },
                //     {
                //         data: "transdate",
                //         name: "transdate",
                //         createdCell: function(td, cellData, rowData, row, col) {
                //             $(td).css("text-transform", "center");
                //         },

                //     }
                // ]
            });

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.manager', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ocqv5p3q51h2/Servilink/resources/views/manager/water_manager.blade.php ENDPATH**/ ?>