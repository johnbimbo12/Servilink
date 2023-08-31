
<?php $__env->startSection('title', "Visitor's Management"); ?>
<?php $__env->startSection('content'); ?>

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                    <h4 class="page-title">Vistor's Management</h4>
                </div>
                <div class="col-lg-9 col-sm-6 col-md-6 col-xs-6">
                    <a href="#" data-toggle="modal" data-target="#modal-visitor"
                        class="btn btn-danger pull-right waves-effect waves-light">Generate Visitor's Token</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <?php echo $__env->make('theme.flash-messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Total Visitors</h3>
                        <ul class="list-inline two-part">
                            <li><span id="tVisitor">0</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">This Month Visitors</h3>
                        <ul class="list-inline  two-part">
                            <li><span id="mVisitor">0</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Today's Visitors</h3>
                        <ul class="list-inline two-part">
                            <li><span id="todayVisit">0</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Today's Entry Request</h3>
                        <ul class="list-inline two-part">
                            <li><span id="entryreq">0</span></li>
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
                                <div class="panel-heading">Visitors Transactions</div>
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
                            <table class="table table-hover" id="visithistory">
                                <thead>
                                    <tr>
                                        <th style="width: 80px;">Visitor's Name</th>
                                        <th style="width: 80px;">Visitor's Number</th>
                                        <th style="width: 80px;">Visiting Token</th>
                                        <th style="width: 80px;">Entry Date</th>
                                        <th style="width: 80px;">Entry Time</th>
                                        <th style="width: 80px;">Entry Status</th>
                                        <th style="width: 80px;">Exit Status</th>
                                        <th style="width: 80px;">Validity Period</th>
                                        <th style="width: 80px;">Action</th>
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

    <div class="modal fade" id="modal-visitor" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content"
                style="border-radius: 8px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Visitor Invitation Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="position: relative;top:-20px;"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="#" enctype="multipart/form-data" id="gentoken">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="form-group col-md-12" style="margin-bottom: 0px">
                                <h5 class="box-title m-t-30">Visitor's Name</h5>
                                <input class="form-control" type="text" name="visitorname" value="" required />
                                <?php $__errorArgs = ['visitorname'];
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
                            <div class="form-group col-md-12" style="margin-bottom: 0px">
                                <h5 class="box-title m-t-30">Visitor's Phone Number</h5>
                                <input class="form-control" type="text" name="visitornumber" value="" required />
                                <?php $__errorArgs = ['visitornumber'];
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
                            <div class="form-group col-md-12" style="margin-bottom: 0px">
                                <h5 class="box-title m-t-30">Select Entry Date</h5>
                                <div class="input-group date" id="id_1">
                                    <input type="text" name="entrydate" value="<?php echo e($date); ?>" class="form-control"
                                        required />
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text">
                                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                                <?php $__errorArgs = ['entrydate'];
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
                            <div class="form-group col-md-12" style="margin-bottom: 0px">
                                <h5 class="box-title m-t-30">Select Entry Time</h5>
                                <div class="input-group date" id="id_2">
                                    <input type="text" name="entrytime" value="<?php echo e($time); ?>" class="form-control"
                                        required />
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text">
                                            <i class="glyphicon glyphicon-time fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                </div>
                                <?php $__errorArgs = ['entrydate'];
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
                            <div class="form-group col-md-12" style="margin-bottom: 0px">
                                <h5 class="box-title m-t-30">Valid Period (1hr - 24hr)</h5>
                                <div class="input-group">
                                    <input name="period" type="number" value="24" min="1" max="24" class="form-control"
                                        required />
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                </div>
                                <?php $__errorArgs = ['period'];
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
                            <input type="text" hidden value="" id="name">
                        </div>
                        <div class="modal-footer" style="padding-left: 0px; padding-right: 0px">
                            <div class="form-group col-md-4">
                                <button class="btn btn-lg btn-info" id="generate" type="submit"
                                    style="border-radius: 8px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); float:left">
                                    Generate
                                </button>
                            </div>
                            <div class="form-group col-md-8">
                                <div class="input-group">
                                    <input id="visit_token" type="text" value="" class="form-control" disabled
                                        style="font-size: 30px; height: 50px;" />
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text">
                                            <i class="fa fa-share-alt-square" style=" font-size: 30px" id="copyAccess"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </form>
                </div>

            </div>
        </div> 

    </div>
    <script type="text/javascript" src=" <?php echo asset('assets/js/jquery-3.3.1.min.js'); ?>"></script>
    <script>
        $(document).ready(function(e) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });
            //<?php echo e(route('generate.visitortoken')); ?>

            $('#gentoken').submit(function(e) {
                toastr.info("Generating token, Please wait !!!");
                e.preventDefault()
                let form = $('#gentoken').serialize();
                console.log(form)
                $.ajax({
                    method: 'POST',
                    url: '<?php echo e(route('generate.visitortoken')); ?>',
                    data: form,
                    success: function(response) {
                        if (response.status == "ok") {
                            $('#visit_token').val(response.data.visiting_token);
                            $('#name').val(response.data.name);
                            toastr.success("Access key generated,kindly share now", {
                                timeOut: 5000
                            });
                            // try {
                            //     navigator.clipboard.writeText(response.data.visiting_token);
                            //     alert('Access key copied to clipboard,')
                            // } catch (error) {
                            // }
                            $('#visithistory').DataTable().draw(true);
                            tablereport.ajax.reload(null, false);
                            $("#modal-edit-resident").modal("hide");
                        } else {
                            toastr.error("Access key generation Fail, Try again !!!", {
                                timeOut: 5000
                            });
                        }
                    }
                });

            });

            $(document).on("click", ".delete", function(e) {
                var id = $(this).attr("data-id");
                if (confirm("Are you sure?")) {
                    $.ajax({
                        url: "<?php echo e(route('delete.accesskey')); ?>",
                        method: 'POST',
                        data: {
                            id: id
                        },
                        success: function(res) {
                            tablereport.ajax.reload(null,
                                false);
                            toastr.success('Access key deleted', {
                                timeOut: 5000
                            });
                            loadVisitorDetails();
                        },
                        error: function(res) {
                            toastr.error('Operation fail', {
                                timeOut: 5000
                            });
                        }
                    });

                }
                return false;
            });

            $('#id_1').datetimepicker({
                "allowInputToggle": true,
                "showClose": true,
                "showClear": true,
                "showTodayButton": true,
                "format": "YYYY-MM-DD",
            });
            $('#id_2').datetimepicker({
                "allowInputToggle": true,
                "showClose": true,
                "showClear": true,
                "showTodayButton": true,
                "format": "HH:mm A",
            });

            function loadVisitorDetails() {
                $.ajax({
                    method: "GET",
                    url: "<?php echo e(route('visitor.stat')); ?>",
                    success: function(msg) {
                        var tVisitor = (msg.tvisitor);
                        var mVisitor = msg.mvisitor;
                        var todayVisit = (msg.todayVisit);
                        var entryreq = msg.entryreq;
                        $("#tVisitor").text(tVisitor);
                        $("#mVisitor").text(mVisitor);
                        $("#todayVisit").text(todayVisit);
                        $("#entryreq").text(entryreq);
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
            loadVisitorDetails();
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
                $('#visithistory').DataTable().draw(true);
                tablereport.ajax.reload(null, false);
            });
            $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {

            });
            $(document).on("click", ".share", function(e) {
                var token = $(this).attr("data-token");
                var name = $(this).attr("data-name");
                try {
                    if (navigator.share) {
                        navigator.share({
                            title: 'Access Token',
                            text: name + ' sent you an visit, here is your access key: ' + token,
                        });
                    }
                } catch (error) {

                }
            })

            $(document).on("click", "#copyAccess", function(e) {
                var token = $('#visit_token').val();
                var name = $('#name').val();
                if (token.length > 0) {
                    try {
                        if (navigator.share) {
                            navigator.share({
                                title: 'Access Token',
                                text: name + ' sent you an visit, here is your access key: ' +
                                    token,
                            });
                        }
                    } catch (error) {

                    }
                } else {
                    alert('Access key not yet generated')
                }

            });


            var tablereport = $("#visithistory").DataTable({
                processing: true,
                "ordering": false,
                "ajax": {
                    "url": "<?php echo route('load.visitors'); ?>",
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

                columns: [

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
                        data: "visiting_token",
                        name: "visiting_token",
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
                    },
                    {
                        data: "entry_time",
                        name: "entry_time",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform");
                        }
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
                        data: "valid_period",
                        name: "valid_period",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform");
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ocqv5p3q51h2/Servilink/resources/views/resident/visitor_manager.blade.php ENDPATH**/ ?>