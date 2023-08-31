
<?php $__env->startSection('title', 'Managers'); ?>
<?php $__env->startSection('content'); ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Estate Manager</h4>
                </div>
            </div>
            <?php echo $__env->make('theme.flash-messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 8px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Registered Managers</h3>
                        <ul class="list-inline two-part">
                            <li><span class="t_manager"><?php echo e(count($managers)); ?></span></li>
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

                            </div>
                            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                                <button style="border-radius: 5px;padding: 10px;;margin:10px" type="button"
                                    id="createmanager"
                                    class="btn btn-danger pull-right m-l-20 waves-effect waves-light">Create
                                    manager account</a>
                            </div>
                            <!-- /.col-lg-12 -->
                        </div>
                        <div class="table-responsive" style="padding-left: 10px;padding-right: 10px">
                            <table class="table table-hover" id="managers">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>No. of Estates</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Revenue Income</th>
                                        <th>Utility Sales</th>
                                        <th style="width: 50px;">Status</th>
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
            Servilink. All
            Rights
            Reserved. </footer>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal-add-manager" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Create Estate Manager </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="position: relative; top:-30px"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div id="edit" style="display: none">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="generaltab active"><a href="#general" aria-controls="general"
                                    role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"></span>
                                    <span class="hidden-xs">General
                                        Setting</span></a></li>
                            <li class="transactiontab" role="presentation"><a href="#transaction"
                                    aria-controls="transaction" role="tab" data-toggle="tab" aria-expanded="false"><span
                                        class="visible-xs"></span><span class="hidden-xs">
                                        Transaction</span></a></li>
                            <li role="presentation" class="settlementtab"><a href="#settlement" aria-controls="settlement"
                                    role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"></span>
                                    <span class="hidden-xs">Settlement
                                        Account</span></a>
                            </li>

                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="general">
                                <div>
                                    <h3>General Setting</h3>
                                </div>
                                <div>
                                    <form method="POST" action="" enctype="multipart/form-data" class="settingform">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="" id="operation" value="add">
                                        <input type="hidden" name="tab" class="tab" value="1">
                                        <input type="hidden" name="user_id" class="userid" value="">
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
                                                        placeholder="Full Name">

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
                                                    <input id="email" type="email"
                                                        class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                        name="email" value="<?php echo e(old('email')); ?>" required
                                                        autocomplete="email" autofocus placeholder="Email Address">

                                                    <?php $__errorArgs = ['email'];
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
                                                    <input id="phone" type="text"
                                                        class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                        name="phone" value="<?php echo e(old('phone')); ?>" autocomplete="phone"
                                                        pattern=".{11,}" required
                                                        title=" Minimum of 11 digits is require for a valid phone number"
                                                        placeholder="Phone Number" autofocus>

                                                    <?php $__errorArgs = ['phone'];
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
                                            <div class="form-group col-md-12" id="mandisable" style="display: none">
                                                <div>
                                                    <label for="">Enable/Disable Manager </label>
                                                    <select name="status" class="form-control" id="status" required>
                                                        <option value="1">Enable</option>
                                                        <option value="0">Disable</option>
                                                    </select>

                                                </div>
                                                <?php $__errorArgs = ['enabled'];
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
                                        <div class="modal-footer">
                                            <button class="btn btn-lg btn-info" type="submit">
                                                Submit
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div role="tabpanel" class="tab-pane transaction" id="transaction">
                                <div>
                                    <h3>Transaction Setting</h3>
                                </div>
                                <div>
                                    <form method="POST" action="" enctype="multipart/form-data" class="transactionform">
                                        <?php echo csrf_field(); ?>

                                        <input type="hidden" name="tab" class="tab" value="2">
                                        <input type="hidden" name="user_id" class="userid" value="">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="">Vending Fee (NGN)</label>
                                                <div>
                                                    <input id="vendfee" type="number" class="form-control" name="vendfee"
                                                        value="300" placeholder="Vend Fee">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="">Sevice Charge Fee (NGN)</label>
                                                <div>
                                                    <input id="servicecharge" type="number" class="form-control"
                                                        name="servicecharge" value="100" placeholder="Service Charge Fee">
                                                </div>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="">Oncredit Purchase Fee (%)</label>
                                                <div>
                                                    <input id="creditfee" type="number" class="form-control"
                                                        name="creditfee" value="20" placeholder="Credit Fee" min="10"
                                                        max="100">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="">Min. Vend (NGN)</label>
                                                <div>
                                                    <input id="minvend" type="number" class="form-control" name="minvend"
                                                        value="30000" placeholder="Minimum vend amount">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-lg btn-info" type="submit">
                                                Submit
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div role="tabpanel" class="tab-pane settlement" id="settlement">
                                <div>
                                    <h3>Settlement Setting</h3>
                                </div>
                                <div>
                                    <form method="POST" action="" enctype="multipart/form-data" class="settlementform">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="tab" class="tab" value="3">
                                        <input type="hidden" name="user_id" class="userid" value="">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label>Power Utility Settlement Details</label>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <input id="power" type="text" class="form-control" name="power"
                                                            value="" placeholder="SubAccount For Power">
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input id="powerbank" type="text" class="form-control"
                                                            name="powerbankname" value="" max="10" placeholder="Bank Name">
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input id="powernuban" type="text" class="form-control"
                                                            name="powernuban" value="" max="10" placeholder="NUBAN Number">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>Service Fee Settlement Details</label>
                                                <div class="row">

                                                    <div class="col-lg-4">
                                                        <input id="service" type="text" class="form-control"
                                                            name="service" value=""
                                                            placeholder="SubAccount For Service charges">
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input id="servicebank" type="text" class="form-control"
                                                            name="servicebankname" value="" max="10"
                                                            placeholder="Bank Name">
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input id="servicenuban" type="text" class="form-control"
                                                            name="servicenuban" value="" max="10"
                                                            placeholder="NUBAN Number">
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="">Water Utility Settlement Details
                                                    No.</label>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <input id="water" type="text" class="form-control" name="water"
                                                            value="" placeholder="SubAccount For Water">
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input id="waterbank" type="text" class="form-control"
                                                            name="waterbankname" value="" max="10" placeholder="Bank Name">
                                                    </div>
                                                    <div class="col-lg-4">

                                                        <input id="waternuban" type="text" class="form-control"
                                                            name="waternuban" value="" placeholder="NUBAN Number">

                                                    </div>
                                                </div>

                                            </div>


                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-lg btn-info" type="submit">
                                                Submit
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="clearfix"></div>

                            </div>

                        </div>
                    </div>
                    <div id="create" style="display: none">
                        <form method="POST" action="" enctype="multipart/form-data" class="createmanager">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <h4 style="margin-left: 10px">Account Details</h4>
                                <div class="form-group col-md-4">

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
                                            placeholder="Full Name">

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

                                <div class="form-group col-md-4">
                                    <div>
                                        <input id="email" type="email"
                                            class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email"
                                            value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus
                                            placeholder="Email Address">

                                        <?php $__errorArgs = ['email'];
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

                                <div class="form-group col-md-4">

                                    <div>
                                        <input id="phone" type="text"
                                            class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="phone"
                                            value="<?php echo e(old('phone')); ?>" autocomplete="phone" pattern=".{11,}" required
                                            title=" Minimum of 11 digits is require for a valid phone number"
                                            placeholder="Phone Number" autofocus>

                                        <?php $__errorArgs = ['phone'];
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
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Power Utility Settlement Details</label>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <input id="powersub" type="text" class="form-control" name="power" value=""
                                                placeholder="SubAccount For Power">
                                        </div>
                                        <div class="col-lg-4">
                                            <input id="powerbankname" type="text" class="form-control"
                                                name="powerbankname" value="" max="10" placeholder="Bank Name">
                                        </div>
                                        <div class="col-lg-4">
                                            <input id="poweract" type="text" class="form-control" name="powernuban"
                                                value="" max="10" placeholder="NUBAN Number">
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group col-md-12">
                                    <label>Service Fee Settlement Details</label>
                                    <div class="row">

                                        <div class="col-lg-4">
                                            <input id="servicesub" type="text" class="form-control" name="service"
                                                value="" placeholder="SubAccount For Service charges">
                                        </div>
                                        <div class="col-lg-4">
                                            <input id="servicebankname" type="text" class="form-control"
                                                name="servicebankname" value="" max="10" placeholder="Bank Name">
                                        </div>
                                        <div class="col-lg-4">
                                            <input id="serviceact" type="text" class="form-control" name="servicenuban"
                                                value="" max="10" placeholder="NUBAN Number">
                                        </div>
                                    </div>


                                </div>

                                <div class="form-group col-md-12">
                                    <label for="">Water Utility Settlement Details
                                        No.</label>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <input id="watersub" type="text" class="form-control" name="water" value=""
                                                placeholder="SubAccount For Water">
                                        </div>
                                        <div class="col-lg-4">
                                            <input id="waterbankname" type="text" class="form-control"
                                                name="waterbankname" value="" max="10" placeholder="Bank Name">
                                        </div>
                                        <div class="col-lg-4">

                                            <input id="wateract" type="text" class="form-control" name="waternuban"
                                                value="" placeholder="NUBAN Number">

                                        </div>
                                    </div>

                                </div>


                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-lg btn-info" id="create_manager" type="submit">
                                    Submit
                                </button>
                            </div>
                        </form>
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

                $(document).on("click", ".delete", function(e) {
                    var id = $(this).attr("data-id");

                    if (confirm("Are you sure?")) {
                        $.ajax({
                            url: "<?php echo e(route('delete.manager')); ?>",
                            method: 'POST',
                            data: {
                                id: id
                            },
                            success: function(res) {
                                $("#managers")
                                    .DataTable()
                                    .draw(true);
                                estate_manager.ajax.reload(null, false);
                                toastr.success(res.Message, {
                                    timeOut: 5000
                                });
                                location.reload();
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


                $(document).on("click", "#createmanager", function(e) {
                    $('#myModalLabel').text('Create Manager Account');
                    $('#operation').val('add');
                    $('#edit').css('display', 'none');
                    $('#create').css('display', 'block');
                    $("#modal-add-manager").modal('show')
                });

                $(document).on("click", ".edit", function(e) {
                    var id = $(this).attr("data-id");
                    $('#myModalLabel').text('Edit Manager');
                    $('#operation').val('edit');
                    $('#edit').css('display', 'block');
                    $('#create').css('display', 'none');
                    $.ajax({
                        method: 'GET',
                        url: "<?php echo e(route('show.manager')); ?>",
                        data: {
                            id: id,
                        },
                        success: function(response) {
                            var data = response.manager;
                            console.log(response)
                            $('.userid').val(id);
                            $('#fullname').val(data.name);
                            $('#email').val(data.email);
                            $('#phone').val(data.phonenumber);
                            var enable = data.status;
                            if (enable == 1) {
                                $("#status option[value=1]").attr('selected', true);
                                $("#status option[value=0]").attr('selected', false);
                            } else if (enable == 0) {
                                $("#status option[value=0]").attr('selected', true);
                                $("#status option[value=1]").attr('selected', false);
                            }

                            var setting = response.setting;
                            if(setting != null){
                                $('.modal-body  #vendfee').val(setting.transaction_fee);
                                $('.modal-body  #servicecharge').val(setting.service_trans_fee);
                                $('.modal-body  #creditfee').val(setting.on_credit_fee);
                                $('.modal-body  #minvend').val(setting.min_vend);
                            }

                            var account = response.account;
                            if(account != null){
                                $('.modal-body  #power').val(account.power);
                                $('.modal-body  #service').val(account.service);
                                $('.modal-body  #water').val(account.water);
                                $('.modal-body  #powerbank').val(account.powerbank);
                                $('.modal-body  #servicebank').val(account.servicebank);
                                $('.modal-body  #waterbank').val(account.waterbank);
                                $('.modal-body  #powernuban').val(account.powernuban);
                                $('.modal-body  #servicenuban').val(account.servicenuban);
                                $('.modal-body  #waternuban').val(account.waternuban);
                            }
                            $("#modal-add-manager").modal('show')
                        }
                    });

                });
                $('.createmanager').submit(function(e) {
                    $("#create_manager").text('Saving...');
                    e.preventDefault();
                    var url = '<?php echo e(route('add.manager')); ?>';
                    let form = $('.createmanager').serialize();
                    $.ajax({
                        method: 'POST',
                        url: url,
                        data: form,
                        success: function(response) {
                            if (response.status = "ok") {
                                $("#managers")
                                    .DataTable()
                                    .draw(true);
                                estate_manager.ajax.reload(null, false);
                                toastr.success(response.Message, {
                                    timeOut: 5000
                                });
                            }
                            $("#create_manager").text("Submit");
                            $("#modal-add-manager").modal('hide')
                        }
                    });
                });

                $('.settingform').submit(function(e) {
                    e.preventDefault();
                    url = '<?php echo e(route('edit.manager')); ?>';
                    let form = $('.settingform').serialize();
                    $.ajax({
                        method: 'POST',
                        url: url,
                        data: form,
                        success: function(response) {
                            if (response.status = "ok") {
                                $("#managers")
                                    .DataTable()
                                    .draw(true);
                                estate_manager.ajax.reload(null, false);
                                toastr.success(response.Message, {
                                    timeOut: 5000
                                });
                            }

                            $("#modal-add-manager").modal('hide')
                        }
                    });
                });


                $('.transactionform').submit(function(e) {
                    e.preventDefault();
                    var url = url = '<?php echo e(route('edit.manager')); ?>';
                    let form = $('.transactionform').serialize();
                    $.ajax({
                        method: 'POST',
                        url: url,
                        data: form,
                        success: function(response) {
                            if (response.status = "ok") {

                                toastr.success(response.Message, {
                                    timeOut: 5000
                                });
                            }
                            $("#modal-add-manager").modal('hide')
                        }
                    });
                });

                $('.settlementform').submit(function(e) {
                    e.preventDefault();
                    var url = url = '<?php echo e(route('edit.manager')); ?>';
                    let form = $('.settlementform').serialize();
                    $.ajax({
                        method: 'POST',
                        url: url,
                        data: form,
                        success: function(response) {
                            if (response.status = "ok") {

                                toastr.success(response.Message, {
                                    timeOut: 5000
                                });
                            }

                            $("#modal-add-manager").modal('hide')
                        }
                    });
                });

                $("#modal-add-manager").on("hide.bs.modal", function(e) {
                    $(".settingform").trigger("reset");
                    $(".settlementform").trigger("reset");
                    $(".transactionform").trigger("reset");
                    $('#ispaid').css('display', 'none')
                });


                var estate_manager = $("#managers").DataTable({
                    processing: true,
                    serverSide: true,
                    "ordering": false,
                    "ajax": {
                        "url": '<?php echo e(route('managers')); ?>',
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
                            data: "estate",
                            name: "estate",
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
                            data: "income",
                            name: "income",
                            createdCell: function(td, cellData, rowData, row, col) {
                                $(td).css("text-transform");
                            },

                        },
                        {
                            data: "sales",
                            name: "sales",
                            createdCell: function(td, cellData, rowData, row, col) {
                                $(td).css("text-transform", "center");
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
                                    return "Locked";
                                } else if (data == 1) {
                                    return "Enabled";
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

<?php echo $__env->make('layouts.manager', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ocqv5p3q51h2/Servilink/resources/views/admin/estate_manager.blade.php ENDPATH**/ ?>