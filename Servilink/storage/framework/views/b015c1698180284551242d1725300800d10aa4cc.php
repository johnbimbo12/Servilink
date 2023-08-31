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
                                <div>
                                    
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
                                                  
                                                </th>
                                                <th colspan="4">
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

                                    <div id="nomsg" style="text-align: center; <?php echo e($msgstat['all'] > 0 ? 'display:none;' : 'display:block;'); ?>"> No request
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

    <script type="text/javascript" src=" <?php echo asset('assets/js/jquery-3.3.1.min.js'); ?>"></script>

    <script>
        $(document).ready(function(e) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });



            var filternum = 0;
            loadmsg(filternum);

            function loadmsg(filter) {
                $.ajax({
                    method: 'GET',
                    url: "<?php echo e(route('load.message')); ?>",
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
                            $('#nomsg').css('display','block');
                            $('.prevnext').css('display','none');
                             $('.stats').css('display','none');
                           
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
                            $('#nomsg').css('display','block');
                            $('.prevnext').css('display','none');
                             $('.stats').css('display','none');
                           
                          
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


                    var check = confirm("Are you sure you want to delete this row?");
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

<?php echo $__env->make('layouts.manager', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ocqv5p3q51h2/Servilink/resources/views/manager/message.blade.php ENDPATH**/ ?>