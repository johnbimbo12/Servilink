<?php $__env->startSection('title', 'Power Management'); ?>
<?php $__env->startSection('content'); ?>
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
                        style="border-radius: 8px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Registered Meters</h3>
                        <ul class="list-inline two-part">
                            <li><span class=""><?php echo e($meter); ?></span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 8px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Revenue <span class="date" style="font-size: 10px"></span></h3>
                        <ul class="list-inline two-part">
                            <li><span> ₦</span><span class="revenue"><?php echo e($prevenue); ?></span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 8px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Vending <span class="date" style="font-size: 10px"></span></h3>
                        <ul class="list-inline  two-part">
                            <li><span> ₦</span><span class="mvend"><?php echo e($monthsale); ?></span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 8px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">On Credit Sale <span class="date" style="font-size: 10px"></span></h3>
                        <ul class="list-inline two-part">
                            <li> <span> ₦</span><span class="oncredit"><?php echo e($credit); ?></span></li>
                        </ul>
                    </div>
                </div>
       

            </div>
            <?php echo $__env->make('theme.flash-messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel"
                        style="border-radius: 8px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">

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
                                        <th style="width: 80px;">Buyer</th>
                                        <th style="width: 80px;">Manager</th>
                                        <th style="width: 80px;">Estate</th>
                                        <th style="width: 80px;">Meter No.</th>
                                        <th style="width: 80px;">TxRef. ID</th>
                                        <th style="width: 80px;">Amount (NGN)</th>
                                        <th style="width: 80px;">Unit (kWH)</th>
                                        <th style="width: 80px;">Vend Channel</th>
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

        <footer class="footer text-center"><?php echo date('Y'); ?> &copy;
           Servilink. All
            Rights
            Reserved. </footer>
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
                    <form method="POST" action="<?php echo e(route('admin.vend')); ?>" enctype="multipart/form-data"
                        id="vendpower">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <input id="meternumber" type="type"
                                    class="form-control meternumber  <?php $__errorArgs = ['meternumber'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    name="meternumber" value="" required placeholder="Enter meter number" autofocus
                                    autocomplete="off">
                                <?php $__errorArgs = ['meternumber'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <input id="amount" type="number"
                                    class="form-control amount  <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    name="amount" value="" required placeholder="Enter amount" autofocus
                                    autocomplete="off">
                                <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="">Payment Channel</label>
                                <select name="channel" id="channel"
                                    class="form-control <?php $__errorArgs = ['channel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="0">Debit/Credit Card</option>
                                        <option value="1">Bank Transfer</option>
                                </select>
                                <?php $__errorArgs = ['channel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <span class="focus-input100" data-placeholder="&#xf207;"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-lg btn-info" id="generate" type="submit">
                                Request Vend
                            </button>
                        </div>
                    </form>
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


            function loadCardDetails() {
                $.ajax({
                    method: "GET",
                    url: "<?php echo e(route('vend.stat')); ?>",
                    data: {
                        start_date: $("#reportrange").attr("data-from"),
                        end_date: $("#reportrange").attr("data-to")
                    },
                    success: function(msg) {                      
                      
                        $(".revenue").text(msg.revenue);
                        $(".mvend").text(msg.vmonth);
                        $(".oncredit").text(mg.credit);


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
                $('#vendhistory').DataTable().draw(true);
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
           

            var tablehistory = $("#vendhistory").DataTable({
                processing: true,
                serverSide: true,
                "ordering": false,
                "ajax": {
                    "url": "<?php echo e(route('vend.history')); ?>",
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
                        data: "buyer",
                        name: "buyer",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform", "sorting_1");
                        }
                    },
                    {
                        data: "manager",
                        name: "manager",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform", "sorting_1");
                        }
                    },
                    {
                        data: "estate",
                        name: "estate",
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

<?php echo $__env->make('layouts.manager', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ocqv5p3q51h2/Servilink/resources/views/admin/power_manager.blade.php ENDPATH**/ ?>