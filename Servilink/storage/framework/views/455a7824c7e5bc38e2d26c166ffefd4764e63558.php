<?php $__env->startSection('title', 'Space Booking'); ?>
<?php $__env->startSection('content'); ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Booking</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Booked Space</h3>
                        <ul class="list-inline two-part">
                            <li><span class="t_space"><?php echo e($bookcnt); ?></span></li>
                        </ul>
                    </div>
                </div>

            </div>
            <?php echo $__env->make('theme.flash-messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">

                        <div class="row ">
                            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                <div class="panel-heading">List</div>
                            </div>
                            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                                <button style="border-radius: 10px;padding: 10px;;margin:10px" type="button" id="bookspace"
                                    data-toggle="modal" data-target="#modal-booking"
                                    class="btn btn-danger pull-right m-l-20 waves-effect waves-light">Book a Venue
                                    Account</a>
                            </div>
                            <!-- /.col-lg-12 -->
                        </div>
                        <div class="table-responsive" style="padding-left: 10px;padding-right: 10px">
                            <table class="table table-hover" id="bookings">
                                <thead>
                                    <tr>
                                        <th style="width: 150px;">Venue Name</th>
                                        <th>Booked Date</th>
                                        <th>Amount Paid</th>
                                        <th>Description</th>
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
    <div class="modal fade" id="modal-booking" role="dialog" data-backdrop="static" data-keyboard="false"
        aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-12">
                        <h4 class="modal-title" id="myModalLabel">Book space</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="position: relative; top:-30px"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <div class="modal-body">
                    <form method="POST" action="#" enctype="multipart/form-data" id="book-space">
                        <?php echo csrf_field(); ?>
                        <div class="row">

                            <input type="hidden" id="data_id" value="0" name="id">
                            <input type="hidden" id="bookdate" value="" name="bookdate">
                            <div>
                                <div class="form-group col-md-12">
                                    <select name="venue" id="venue"
                                        class="form-control <?php $__errorArgs = ['space'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="0">Select Venue/ Location</option>
                                        <?php $__currentLoopData = $spaces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $space): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($space->id); ?>" data-amount="<?php echo e($space->cost); ?>">
                                                <?php echo e($space->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['space'];
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
                                <div class="form-group col-md-12">
                                    <label for="availabledate"  id="bdate"> Pick Event Date From Current Month </label>
                                    <div id="availabledate" class="row" style="margin:0px !important">

                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <div>
                                        <input id="cost" type="text" class="form-control" value="" readonly>
                                    </div>
                                </div>
                                <div class=" form-group col-md-12">
                                    <div>
                                        <textarea id="decription" type="text" class="form-control" name="description"
                                            cols="4" value="" required autofocus placeholder="Usage Description"></textarea>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-lg btn-info" id="saveresident" type="submit">
                                Submit
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


            $('#venue').change(function() {
                let amount = parseInt($(this).find("option:selected").attr('data-amount'));
                amount = (amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                let id = $(this).find("option:selected").attr('value');
                $.ajax({
                    method: 'GET',
                    url: "<?php echo e(route('load.space')); ?>",
                    data: {
                        id: id,
                    },
                    success: function(response) {
                        var list = response;

                        for (var value of list) {

                            $('#availabledate')
                                .append(
                                    `<div class="col-sm-4"> <input  class="check" type="checkbox" id="${value}" name="interest" data-date="${value}" value="${value}" style="margin-right:10px">` +
                                    `<label for="${value}">${value}</label></div>`);

                        }
                    }
                });
                $('#cost').val('NGN ' + amount);

            });
            $(document).on("click", ".check", function(e) {
                let date = $(this).attr('value');
                $('#bookdate').val(date);
                $('.check').not(this).prop('checked', false);
            });

            $(document).on("click", ".edit", function(e) {
                var id = $(this).attr("data-id");
               
                $.ajax({
                    method: 'GET',
                    url: "<?php echo e(route('show.booking')); ?>",
                    data: {
                        id: id,
                    },
                    success: function(response) {
                        var data = response;
                        $('.modal-body  #data_id').val(id);
                        $('.modal-title').text("Update Booking Details");
                        $(".modal-body #venue option[value=" + data.space_id + "]").attr(
                            'selected', true);
                        $('.modal-body  #bdate').text("Booked Date: " +data.booking_date);
                        $('.modal-body  #cost').val('NGN ' + data.cost);
                        $('.modal-body  textarea#description').html(data.description);
                        $("#modal-booking").modal('show')
                    }
                });
            });
            $(document).on("click", ".delete", function(e) {
                var id = $(this).attr("data-id");
                if (confirm("Are you sure?")) {
                    $.ajax({
                        url: "<?php echo e(route('delete.booking')); ?>",
                        method: 'POST',
                        data: {
                            id: id
                        },
                        success: function(res) {
                            bookings.ajax.reload(null,
                                false);
                            toastr.success('Booking account Deleted', {
                                timeOut: 5000
                            });
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
            $('#book-space').submit(function(e) {
                e.preventDefault()
                let form = $('#book-space').serialize();
                var url = "<?php echo e(route('store.booking')); ?>";
                if ($('#data_id').val() !== "0") {
                    url = "<?php echo e(route('edit.booking')); ?>";
                }
                $.ajax({
                    method: 'POST',
                    url: url,
                    data: form,
                    success: function(response) {
                        if (response.status = "ok") {
                            $("#bookings")
                                .DataTable()
                                .draw(true);
                            bookings.ajax.reload(null, false);
                        }
                        toastr.success(response.Message, {
                            timeOut: 5000
                        });
                        $("#modal-booking").modal('hide')
                    }
                });
            });

            var bookings = $("#bookings").DataTable({
                processing: true,
                serverSide: true,
                "ordering": false,
                "ajax": {
                    "url": '<?php echo e(route('index.booking')); ?>',

                },
                dom: 'Blfrtip',
                "pageLength": 50,
                buttons: [
                    'csv', 'excel', 'pdf',
                ],

                columns: [{
                        data: "venue",
                        name: "venue",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform", "sorting_1");
                        }
                    },

                    {
                        data: "booking_date",
                        name: "booking_date",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform", "sorting_1");
                        }
                    },
                    {
                        data: "cost",
                        name: "cost",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform");
                        },

                    },
                    {
                        data: "description",
                        name: "description",
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
                            if (data == 1) {
                                return "Expire";
                            } else {
                                return "Not Used";
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ocqv5p3q51h2/Servilink/resources/views/resident/booking.blade.php ENDPATH**/ ?>