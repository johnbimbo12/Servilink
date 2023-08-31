<!-- Modal -->
<div class="modal fade" id="modal-add-user" role="dialog" data-backdrop="static" data-keyboard="false"
    aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-md" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <div class="col-12">
                    <h4 class="modal-title" id="myModalLabel">Create resident account </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="position: relative; top:-30px"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="row" style="margin: 20px;">
                    <button type="button" id="single" class="btn btn-lg btn-info pull-right" style="float: right">
                        <?php echo e(__('Single Registration  ')); ?>

                    </button>
                    <button type="button" id="buck" class="btn btn-lg btn-info pull-left" style="float: left">
                        <?php echo e(__('Upload Template')); ?>

                    </button>
                </div>

            </div>
            <div class="modal-body">
                <form method="POST" action="" enctype="multipart/form-data" id="create-regular" style="display: none">
                    <?php echo csrf_field(); ?>
                    <input name="file" value="0" id="file" hidden>
                    <div class="row">
                        <div>
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
                            <div class="form-group col-md-12">

                                <div>
                                    <input id="housenum" type="text"
                                        class="form-control <?php $__errorArgs = ['housenum'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="housenum"
                                        value="<?php echo e(old('housenum')); ?>" autocomplete="housenum" required
                                        placeholder="House Number" autofocus>

                                    <?php $__errorArgs = ['housenum'];
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
                                <select name="estate" id="estate"
                                    class="form-control <?php $__errorArgs = ['estate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <option value="0">Select Estate</option>
                                    <?php $__currentLoopData = $estates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($estate->id); ?>">
                                            <?php echo e($estate->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['estate'];
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
                                <div>
                                    <input id="meterpan" type="number"
                                        class="form-control <?php $__errorArgs = ['meterpan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="meterpan"
                                        value="<?php echo e(old('meterpan')); ?>" placeholder="Meter Number" autofocus>
                                    <?php $__errorArgs = ['meterpan'];
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
                                    <input id="water" type="number"
                                        class="form-control <?php $__errorArgs = ['water'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="water" value=""
                                        placeholder="Flow Meter Number" autofocus>
                                    <?php $__errorArgs = ['water'];
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
                                <label class="label-checkbox100" for="checkpaid">
                                    Service Charge Paid?
                                </label>
                                <input class="input-checkbox100" id="checkpaid" type="checkbox" name="paidservicefee">

                            </div>
                              <div class="form-group col-md-12">
                                <label class="label-checkbox100" for="meterchk">
                                    New Meter?
                                </label>
                                <input class="input-checkbox100" id="meterchk" type="checkbox" name="newmeter">

                            </div>
                            <div id="ispaid" style="display: none">
                                <div class="form-group col-md-12">
                                    <label class="label-checkbox100" for="payday">
                                        Payment date
                                    </label>
                                    <input id="payday" class="form-control" type="date" name="paymentdate">
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="label-checkbox100">
                                        Number paid month
                                    </label>
                                    <input id="nummonth" type="number"
                                        class="form-control <?php $__errorArgs = ['nummonth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="nummonth"
                                        value="1" min="1" placeholder=" Number of months" autocomplete="off">
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
                <form method="POST" action="<?php echo e(route('store.user')); ?>" enctype="multipart/form-data"
                    id="templateupload" style="display: none; margin-top:10px">
                    <?php echo csrf_field(); ?>
                    <input name="file" value="1" id="file" hidden>
                    <div>
                        <div class="form-group col-md-12" style="max-width: 500px;">
                            <label class="custom-file-label" for="customFile">Choose Estate Template File</label>
                            <div class="custom-file text-left">
                                <input type="file" name="file" class="custom-file-input" id="customFile"
                                    accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-lg btn-info" id="upload" type="submit">
                            Submit
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div> 
</div>
<?php /**PATH /home/ocqv5p3q51h2/Servilink/resources/views/modal/create-user.blade.php ENDPATH**/ ?>