@extends('layouts.manager')
@section('title', 'Messages')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Messages</h4>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- row -->
            @include('theme.flash-messages')
            <div class="row">
                <!-- Left sidebar -->
                <div class="col-md-12">
                    <div class="white-box">
                        <!-- row -->
                        <div class="row">
                            <div class="col-lg-2 col-md-3  col-sm-12 col-xs-12 inbox-panel">
                                <div>
                                    {{-- <a href="#" class="btn btn-custom btn-block waves-effect waves-light"
                                        data-toggle="modal" data-target="#modal-messaging">New Request</a> --}}
                                    <div class="list-group mail-list m-t-20"> <a href="#" data-id="0"
                                            class="list-group-item active filter">All
                                            request <span
                                                class="label label-rouded label-purple pull-right">{{ $msgstat['all'] }}</span></a>
                                        <a href="#" class="list-group-item active filter" data-id="2">Pending <span
                                                class="label label-rouded label-warning pull-right">{{ $msgstat['pending'] }}</span></a>
                                        <a href="#" class="list-group-item active filter" data-id="3">Processing <span
                                                class="label label-rouded label-info pull-right">{{ $msgstat['process'] }}</span></a>
                                        <a href="#" class="list-group-item active filter" data-id="1">Resolved <span
                                                class="label label-rouded label-success pull-right">{{ $msgstat['resolved'] }}</span></a>
                                        <a href="#" class="list-group-item active filter" data-id="5">Unread <span
                                                class="label label-rouded label-danger pull-right">{{ $msgstat['unread'] }}</span></a>
                                        <a href="#" class="list-group-item active filter" data-id="4">Read <span
                                                class="label label-rouded label-info pull-right">{{ $msgstat['read'] }}</span></a>
                                    </div>
                                    {{-- <h3 class="panel-title m-t-40 m-b-0">Category</h3>
                                    <hr class="m-t-5">
                                    <div class="list-group b-0 mail-list"> <a href="#" class="list-group-item"><span
                                                class="fa fa-circle text-info m-r-10"></span>Energy Purchase</a> <a href="#"
                                            class="list-group-item"><span
                                                class="fa fa-circle text-warning m-r-10"></span>Water Purchase</a> <a
                                            href="#" class="list-group-item"><span
                                                class="fa fa-circle text-purple m-r-10"></span>Service Charges</a>
                                        <a href="#" class="list-group-item"><span
                                                class="fa fa-circle text-purple m-r-10"></span>Payment Issue</a> <a href="#"
                                            class="list-group-item"><span
                                                class="fa fa-circle text-danger m-r-10"></span>Others</a>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12 mail_listing">
                                <div class="table-responsive" style="padding-left: 10px;padding-right: 10px">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th width="30">
                                                    {{-- <div class="checkbox m-t-0 m-b-0 ">
                                                        <input id="checkall" type="checkbox" class="checkbox-toggle"
                                                            value="check all">
                                                        <label></label>
                                                    </div> --}}
                                                </th>
                                                <th colspan="4">


                                                    {{-- <div class="btn-group">
                                                        <button type="button"
                                                            class="btn btn-default waves-effect waves-light  dropdown-toggle delete_all"
                                                            data-toggle="dropdown" aria-expanded="false"> <i
                                                                class="fa fa-trash text-danger"></i> </button>
                                                    </div> --}}
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
                                        <tbody id="messages">

                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">

                                    <div class="col-xs-7 m-t-20 stats"
                                        style="{{ $msgstat['all'] > 0 ? 'display:block;' : 'display:none;' }}"></div>

                                    <div id="nomsg" style="text-align: center; {{ $msgstat['all'] > 0 ? 'display:none;' : 'display:block;' }}"> No request
                                    </div>

                                    <div class="col-xs-5 m-t-20 prevnext"
                                        style="{{ $msgstat['all'] > 0 ? 'display:block;' : 'display:none;' }}">
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

    <script type="text/javascript" src=" {!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>

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
                    url: "{{ route('load.message') }}",
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
                            url: "{{ route('delete.request') }}",
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
@endsection
