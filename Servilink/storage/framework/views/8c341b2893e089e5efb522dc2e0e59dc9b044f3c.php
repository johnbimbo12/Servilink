<?php $__env->startSection('title', 'Request Details'); ?>
<?php $__env->startSection('content'); ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title"> <a href="<?php echo e(route('messaging')); ?>">Message/</a> Request Details</h4>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- row -->
            <div class="row">
                <!-- Left sidebar -->
                <div class="col-md-12">
                    <div class="white-box">
                        <!-- row -->
                        <div class="row">
                            <div class="col-lg-2 col-md-3  col-sm-12 col-xs-12 inbox-panel">
                                <div> 
                                    <div class="list-group mail-list m-t-20"> <a href="<?php echo e(route('messaging')); ?>" data-id="0"
                                            class="list-group-item active filter">All
                                            request <span
                                                class="label label-rouded label-purple pull-right"><?php echo e($msgstat['all']); ?></span></a>
                                        <a href="<?php echo e(route('messaging')); ?>" class="list-group-item active filter" data-id="2">Pending <span
                                                class="label label-rouded label-warning pull-right"><?php echo e($msgstat['pending']); ?></span></a>
                                        <a href="<?php echo e(route('messaging')); ?>" class="list-group-item active filter" data-id="3">Processing <span
                                                class="label label-rouded label-info pull-right"><?php echo e($msgstat['process']); ?></span></a>
                                        <a href="<?php echo e(route('messaging')); ?>" class="list-group-item active filter" data-id="1">Resolved <span
                                                class="label label-rouded label-success pull-right"><?php echo e($msgstat['resolved']); ?></span></a>
                                        <a href="<?php echo e(route('messaging')); ?>" class="list-group-item active filter" data-id="5">Unread <span
                                                class="label label-rouded label-danger pull-right"><?php echo e($msgstat['unread']); ?></span></a>
                                        <a href="<?php echo e(route('messaging')); ?>" class="list-group-item active filter" data-id="4">Read <span
                                                class="label label-rouded label-info pull-right"><?php echo e($msgstat['read']); ?></span></a>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-lg-10 col-md-9 col-sm-8 col-xs-12 mail_listing">
                                <h4 class="font-bold m-t-0"><?php echo e($message[0]->title); ?></h4>
                                <hr>
                                <?php $__currentLoopData = $message; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="media m-b-30 p-t-20">
                                        <div class="media-body"> <span
                                                class="media-meta pull-right"><?php echo e($msg->created_at->diffForHumans()); ?>

                                            </span>

                                            <h4 class="text-danger m-0">
                                                <?php if(auth::id() == $msg->user_id): ?>
                                                    Me
                                                <?php else: ?>
                                                    <?php echo e($msg->sender); ?>

                                                <?php endif; ?>
                                            </h4>
                                        </div>
                                    </div>

                                    <p><?php echo e($msg->request); ?></p>

                                    <hr>
                                    <?php if($msg->attachment): ?>
                                        <h4> <i class="fa fa-paperclip m-r-10 m-b-10"></i> Attachments <span>
                                                <?php echo e(count(json_decode($msg->attachment->path))); ?></span> </h4>
                                        <?php if(count(json_decode($msg->attachment->path)) > 0): ?>
                                            <div class="row">
                                                <?php $__currentLoopData = json_decode($msg->attachment->path); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                    <div class="col-sm-2 col-xs-4">
                                                        <a href="#"> <img class="img-thumbnail img-responsive"
                                                                alt="attachment"
                                                                src="<?php echo e(asset('storage/attachments/' . $file)); ?>"> </a>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <hr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if(count($message) > 1): ?>
                                    <div class="b-all p-20">
                                        <p class="p-b-20">click here to <a href="#" class="reply"
                                                data-toggle="modal" data-type="reply"
                                                data-parent="<?php echo e($message[0]->parent_id); ?>"
                                                data-target="#modal-messaging">Reply</a></p>
                                    </div>
                                <?php else: ?>
                                    <div class="b-all p-20">
                                        <p class="p-b-20">click here to <a href="#" class="reply"
                                                data-toggle="modal" data-type="reply" data-parent="<?php echo e($message[0]->id); ?>"
                                                data-target="#modal-messaging">Reply</a></p>
                                    </div>
                                <?php endif; ?>

                            </div>

                        </div>
                        <!-- /.row -->
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
    </div>
    <div class="modal fade" id="modal-messaging" data-backdrop="static" data-keyboard="false" role="dialog"
        aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content"
                style="border-radius:5px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">New request </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="position: relative; top: -30px"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                    <form method="POST" action="<?php echo e(route('message.save')); ?>" enctype="multipart/form-data"
                        id="sendrequest">
                        <?php echo csrf_field(); ?>
                        <input type="text" name="type" id="reqtype" value="" hidden>
                        <input type="text" name="parentid" id="parentid" value="" hidden>
                        <div class="row">
                            
                           
                            <div class="form-group">
                                <textarea class="textarea_editor form-control" rows="15" name="message"
                                    placeholder="Enter text ..."></textarea>
                            </div>
                            <div class="form-group">
                                <label>Request Status</label>
                                <select name="status" id="status" class="form-control">
                                    
                                    <option value="0"  selected="selected">Pending</option>
                                    <option value="1">Processing</option>
                                    <option value="2">Resolved</option>
                                </select>
                            </div>
                            <h4><i class="ti-link"></i> Attachment</h4>

                            <div class="fallback">
                                <input name="attachment[]" type="file" class="form-control" multiple="multiple">
                            </div>

                            <hr>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
                            <button class="btn btn-default" data-dismiss="modal" aria-label="Close"><i
                                    class="fa fa-times"></i> Discard</button>

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
            $(document).on("click", ".reply", function(e) {
                var type = $(this).attr("data-type");
              
                if (type == "reply") {
                    var parent = $(this).attr("data-parent");
                    $('.modal-title').text('Reply Request')
                    $('#reqtype').val('reply');
                    $('#parentid').val(parent);
                }
            });

            $("#modal-messaging").on('show.bs.modal', function() {

            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.manager', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ocqv5p3q51h2/Servilink/resources/views/manager/message_details.blade.php ENDPATH**/ ?>