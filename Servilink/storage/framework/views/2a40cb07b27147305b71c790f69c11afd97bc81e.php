<?php $__env->startSection('title', 'Messages'); ?>
<?php $__env->startSection('content'); ?>
<style>
    [data-href] { cursor: pointer; }
</style>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Messages</h4>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- row -->
            <?php echo $__env->make('theme.flash-messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="row">
                <!-- Left sidebar -->
                <div class="col-md-12">
                    <div class="white-box">
                        <!-- row -->
                        <div class="row">
                            <div class="col-lg-2 col-md-3  col-sm-12 col-xs-12 inbox-panel">
                                <div> <a href="#" class="btn btn-custom btn-block waves-effect waves-light"
                                        data-toggle="modal" data-target="#modal-messaging">New Request</a>
                                    <div class="list-group mail-list m-t-20"> <a href="#" data-id="0"
                                            class="list-group-item active filter">All
                                            request <span
                                                class="label label-rouded label-purple pull-right"><?php echo e($msgstat['all']); ?></span></a>
                                        <a href="#" class="list-group-item active filter" data-id="2">Pending <span
                                                class="label label-rouded label-warning pull-right"><?php echo e($msgstat['pending']); ?></span></a>
                                        <a href="#" class="list-group-item active filter" data-id="3">Processing <span
                                                class="label label-rouded label-info pull-right"><?php echo e($msgstat['process']); ?></span></a>
                                        <a href="#" class="list-group-item active filter" data-id="1">Resolved <span
                                                class="label label-rouded label-success pull-right"><?php echo e($msgstat['resolved']); ?></span></a>
                                        <a href="#" class="list-group-item active filter" data-id="5">Unread <span
                                                class="label label-rouded label-danger pull-right"><?php echo e($msgstat['unread']); ?></span></a>
                                        <a href="#" class="list-group-item active filter" data-id="4">Read <span
                                                class="label label-rouded label-info pull-right"><?php echo e($msgstat['read']); ?></span></a>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12 mail_listing">
                                <div class="table-responsive" style="padding-left: 10px;padding-right: 10px">
                                    <table class="table table-hover">

                                        <thead>
                                            <tr>
                                                <th width="30">
                                                    <div class="checkbox m-t-0 m-b-0 ">
                                                        <input id="checkall" type="checkbox" class="checkbox-toggle"
                                                            value="check all">
                                                        <label></label>
                                                    </div>
                                                </th>
                                                <th colspan="4">


                                                    <div class="btn-group">
                                                        <button type="button"
                                                            class="btn btn-default waves-effect waves-light  dropdown-toggle delete_all"
                                                            data-toggle="dropdown" aria-expanded="false"> <i
                                                                class="fa fa-trash text-danger"></i> </button>
                                                    </div>
                                                </th>
                                                <th class="hidden-xs" width="100">
                                                    <div class="btn-group pull-right">
                                                        <button data-href="" type="button"
                                                            class="btn btn-default waves-effect prev"><i
                                                                class="fa fa-chevron-left"></i></button>
                                                        <button data-href="" type="button"
                                                            class="btn btn-default waves-effect next"><i
                                                                class="fa fa-chevron-right"></i></button>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Sender</th>
                                                <th  class="hidden-xs">Title</th>
                                                <th>Message</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="messages">

                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-xs-7 m-t-20 stats"
                                        style="<?php echo e($msgstat['all'] > 0 ? 'display:block;' : 'display:none;'); ?>"></div>

                                    <div id="nomsg"
                                        style="text-align: center; <?php echo e($msgstat['all'] > 0 ? 'display:none;' : 'display:block;'); ?>">
                                        No request
                                    </div>

                                    <div class="col-xs-5 m-t-20 prevnext"
                                        style="<?php echo e($msgstat['all'] > 0 ? 'display:block;' : 'display:none;'); ?>">
                                        <div class="btn-group pull-right">
                                            <button data-href="" type="button" class="btn btn-default waves-effect prev"><i
                                                    class="fa fa-chevron-left"></i></button>
                                            <button data-href="" type="button" class="btn btn-default waves-effect next"><i
                                                    class="fa fa-chevron-right"></i></button>
                                        </div>
                                    </div>
                                </div>
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
                        <input type="text" name="type" id="reqtype" value="new" hidden>
                        <div class="row">
                            <div class="form-group">
                                <input class="form-control" placeholder="Subject:" name="title">
                            </div>
                            <div class="form-group">
                                <select name="category" id="category" class="form-control" required>
                                    <option value="">Request Category </option>
                                    <option value="2">Water Unit Purchase</option>
                                    <option value="0">Power Unit Purchase</option>
                                    <option value="1">Service Charge</option>
                                    <option value="4">Payment Issue</option>
                                    <option value="3">Other Issue</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <textarea class="textarea_editor form-control" rows="15" name="message"
                                    placeholder="Enter text ..."></textarea>
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

            $("#modal-messaging").on('hide.bs.modal', function() {
                $('#sendrequest').removeAttr('disabled');
            });

            $("#modal-messaging").on('show.bs.modal', function() {
                $('#sendrequest').removeAttr('disabled');
            });

            $('#sendrequest').submit(function(e) {
                $('#sendrequest').attr('disabled', true);
            });

            var filternum = 0;
            loadmsg(filternum);

            function loadmsg(filter) {
                $.ajax({
                    method: 'GET',
                    url: "<?php echo e(route('message.load')); ?>",
                    data: {
                        filter: filter
                    },
                    success: function(response) {
                        $("#messages").empty();
                        if (response.status == 'ok') {
                            $("#messages").append(response.html);
                            var show = response.paginate.current_page + ' - ' + response.paginate
                                .per_page + ' of ' + response.paginate.total
                            $('.stats').text(show);
                            $('.prev').data("href", response.paginate.prev_page_url);
                            $('.next').data("href", response.paginate.next_page_url);
                            $('#nomsg').css('display', 'none');
                            $('.prevnext').css('display', 'block');
                            $('.stats').css('display', 'block');
                        } else {
                            $('#nomsg').css('display', 'block');
                            $('.prevnext').css('display', 'none');
                            $('.stats').css('display', 'none');
                        }
                    }
                });
            }

            function loadnextprevmsg(filter, url) {
                $.ajax({
                    method: 'GET',
                    url: url,
                    data: {
                        filter: filter
                    },
                    success: function(response) {
                        console.log(response);
                        $("#messages").empty();

                        if (response.status == 'ok') {
                            $("#messages").append(response.html);
                            var show = response.paginate.current_page + ' - ' + response.paginate
                                .per_page + ' - of' + response.paginate.total
                            $('.stats').text(show);
                            $('.prev').data("href", response.paginate.prev_page_url);
                            $('.next').data("href", response.paginate.next_page_url);
                            $('#nomsg').css('display', 'none');
                            $('.prevnext').css('display', 'block');
                            $('.stats').css('display', 'block');
                        } else {
                            $('#nomsg').css('display', 'block');
                            $('.prevnext').css('display', 'none');
                            $('.stats').css('display', 'none');

                        }
                    }
                });
            }

            $(document).on("click", ".prev", function(e) {
                var url = $(this).attr("data-href");
                loadnextprevmsg(filternum, url);
            });

            $(document).on("click", ".next", function(e) {
                var url = $(this).attr("data-href");
                loadnextprevmsg(filternum, url);
            });

            $(document).on("click", ".filter", function(e) {
                var id = $(this).attr("data-id");
                loadmsg(id);
            });

            $('#checkall').on('click', function(e) {
                if ($(this).is(':checked', true)) {
                    $(".sub_chk").prop('checked', true);
                } else {
                    $(".sub_chk").prop('checked', false);
                }
            });


            $('.delete_all').on('click', function(e) {
                var allVals = [];
                $(".sub_chk:checked").each(function() {
                    allVals.push($(this).attr('data-id'));
                });

                if (allVals.length <= 0) {
                    alert("Please select row.");
                } else {


                    var check = confirm("Are you sure you want to delete the message?");
                    if (check == true) {


                        var join_selected_values = allVals.join(",");

                        $.ajax({
                            url: "<?php echo e(route('delete.request')); ?>",
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: 'ids=' + join_selected_values,
                            success: function(data) {
                                if (data['success']) {
                                    $(".sub_chk:checked").each(function() {
                                        $(this).parents("tr").remove();
                                    });
                                    toastr.success(data['success'], {
                                        timeOut: 5000
                                    });

                                } else if (data['error']) {
                                    toastr.error("Error occur", {
                                        timeOut: 5000
                                    });

                                } else {
                                    toastr.error("Error occur", {
                                        timeOut: 5000
                                    });

                                }
                            },
                            error: function(data) {
                                toastr.error("Error occur", {
                                    timeOut: 5000
                                });

                            }
                        });


                        $.each(allVals, function(index, value) {
                            $('table tr').filter("[data-row-id='" + value + "']").remove();
                        });
                    }
                }
            });



        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ocqv5p3q51h2/Servilink/resources/views/resident/message.blade.php ENDPATH**/ ?>