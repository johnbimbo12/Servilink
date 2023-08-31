
<?php $__env->startSection('title', 'Estates Management'); ?>
<?php $__env->startSection('content'); ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Estates</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <div class="white-box" style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Registered Estate</h3>
                        <ul class="list-inline two-part">
                            <li><span class="t_resident"><?php echo e($estates); ?></span></li>
                        </ul>
                    </div>
                </div>
               
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel" style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">

                        <div class="row ">
                            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                <div class="panel-heading">Estates List</div>
                            </div>
                            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                                <button style="border-radius: 10px;padding: 10px;;margin:10px" type="button" id="createestate" data-toggle="modal"
                                    data-target="#modal-add-estate"
                                    class="btn btn-danger pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Create
                                    Estate account</a>
                            </div>
                            <!-- /.col-lg-12 -->
                        </div>
                        <div class="table-responsive" style="padding-left: 10px;padding-right: 10px">
                            <table class="table table-hover" id="estatelist">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th >Residents Count</th>
                                        <th>Address</th>
                                        <th>Service Fee</th>
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
        <footer class="footer text-center"><?php echo date('Y'); ?> &copy;
           Servilink. All
            Rights
            Reserved. </footer>
    </div>
   <!-- Modal -->
<div class="modal fade" id="modal-add-estate" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-md" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Create estate account </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" enctype="multipart/form-data" id="create-estate">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <div>
                                <input id="fullname" type="text"
                                    class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name"
                                    value="<?php echo e(old('name')); ?>" required autocomplete="name" autofocus
                                    placeholder="Estate Name">

                                <?php $__errorArgs = ['name'];
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
                        <div class="form-group col-md-12">

                            <div>
                                <input id="address" type="text" class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    name="address" value="<?php echo e(old('address')); ?>"
                                    required
                                    placeholder="Address" autofocus>

                                <?php $__errorArgs = ['address'];
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
                      
                        <div class="form-group col-md-12">
                            <div>
                                <input id="service_charge" type="number"
                                    class="form-control <?php $__errorArgs = ['service_charge'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="service_charge"
                                    value="<?php echo e(old('service_charge')); ?>" placeholder="Service Charge" autofocus>
                                <?php $__errorArgs = ['service_charge'];
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
                       
                   </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-lg btn-info" id="generate" type="submit">
                    Submit
                </button>
            </div>
            </form>
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

        $(document).on("click", ".delete", function(e) {
            var id = $(this).attr("data-id");

            if (confirm("Are you sure?")) {
                $.ajax({
                    url: "<?php echo e(route('delete.estate')); ?>",
                    method: 'POST',
                    data:{
                        id:id
                    },
                    success: function(res) {
                        estate_list.ajax.reload(null,
                        false); 
                        toastr.success('Estate Deleted', {
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

       
        $('#create-estate').submit(function(e) {
            e.preventDefault()
            toastr.success("Saving, Please wait !!!", {
                            timeOut: 5000
                        });
            let form = $('#create-estate').serialize();
            $.ajax({
                method: 'POST',
                url: '<?php echo e(route("create.estate")); ?>',
                data: form,
                success: function(response) {
                    if (response.status = "ok") {
                        $("#estatelist")
                            .DataTable()
                            .draw(true);
                        estate_list.ajax.reload(null, false);
                        toastr.success(response.Message, {
                            timeOut: 5000
                        });
                    }
                    toastr.success(response.Message, {
                        timeOut: 5000
                    });
                   
                    $("#modal-add-estate").modal('hide')
                }
            });
        });


        $("#modal-add-estate").on("show.bs.modal", function(e) {
            $("#create-estate").trigger("reset");
        });    

        var estate_list = $("#estatelist").DataTable({
            processing: true,
            serverSide: true,
            "ordering": false,
            "ajax": {
                "url": '<?php echo e(route("load.estate")); ?>',

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
                    data: "resident",
                    name: "resident",
                    createdCell: function(td, cellData, rowData, row, col) {
                        $(td).css("text-transform", "sorting_1");
                    }
                },{
                    data: "address",
                    name: "address",
                    createdCell: function(td, cellData, rowData, row, col) {
                        $(td).css("text-transform", "sorting_1");
                    }
                },
                {
                    data: "service_charge",
                    name: "service_charge",
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

<?php echo $__env->make('layouts.manager', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ocqv5p3q51h2/Servilink/resources/views/manager/manager_estate.blade.php ENDPATH**/ ?>