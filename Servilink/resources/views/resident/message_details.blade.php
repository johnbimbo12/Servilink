@extends('layouts.user')
@section('title', 'Request Details')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title"> <a href="{{ route('messaging') }}">Message/</a> Request Details</h4>
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
                                <div> <a href="#" class="btn btn-custom btn-block waves-effect waves-light"
                                        data-toggle="modal" data-target="#modal-messaging" data-type="new">New Request</a>

                                    <div class="list-group mail-list m-t-20"> <a href="{{ route('messaging') }}" data-id="0"
                                            class="list-group-item active filter">All
                                            request <span
                                                class="label label-rouded label-purple pull-right">{{ $msgstat['all'] }}</span></a>
                                        <a href="{{ route('messaging') }}" class="list-group-item active filter"
                                            data-id="2">Pending <span
                                                class="label label-rouded label-warning pull-right">{{ $msgstat['pending'] }}</span></a>
                                        <a href="{{ route('messaging') }}" class="list-group-item active filter"
                                            data-id="3">Processing <span
                                                class="label label-rouded label-info pull-right">{{ $msgstat['process'] }}</span></a>
                                        <a href="{{ route('messaging') }}" class="list-group-item active filter"
                                            data-id="1">Resolved <span
                                                class="label label-rouded label-success pull-right">{{ $msgstat['resolved'] }}</span></a>
                                        <a href="{{ route('messaging') }}" class="list-group-item active filter"
                                            data-id="5">Unread <span
                                                class="label label-rouded label-danger pull-right">{{ $msgstat['unread'] }}</span></a>
                                        <a href="{{ route('messaging') }}" class="list-group-item active filter"
                                            data-id="4">Read <span
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
                            <div class="col-lg-10 col-md-9 col-sm-8 col-xs-12 mail_listing">
                                <h4 class="font-bold m-t-0">{{ $message[0]->title }}</h4>
                                <hr>
                                @foreach ($message as $msg)
                                    <div class="media m-b-30 p-t-20">
                                        <div class="media-body"> <span
                                                class="media-meta pull-right">{{ $msg->created_at->diffForHumans() }}
                                            </span>

                                            <h4 class="text-danger m-0">
                                                @if (auth::id() == $msg->user_id)
                                                    Me
                                                @else
                                                    Manager
                                                @endif
                                            </h4>
                                        </div>
                                    </div>

                                    <p>{{ $msg->request }}</p>

                                    <hr>
                                    @if ($msg->attachment)
                                        <h4> <i class="fa fa-paperclip m-r-10 m-b-10"></i> Attachments <span>
                                                {{ count(json_decode($msg->attachment->path)) }}</span> </h4>
                                        @if (count(json_decode($msg->attachment->path)) > 0)
                                            <div class="row">
                                                @foreach (json_decode($msg->attachment->path) as $file)

                                                    <div class="col-sm-2 col-xs-4">
                                                        <a href="#"> <img class="img-thumbnail img-responsive"
                                                                alt="attachment"
                                                                src="{{ asset('storage/attachments/' . $file) }}"> </a>
                                                    </div>
                                                @endforeach

                                            </div>
                                        @endif
                                    @endif

                                    <hr>
                                @endforeach
                                @if (count($message) > 1)
                                    <div class="b-all p-20">
                                        <p class="p-b-20">click here to <a href="#" class="reply"
                                                data-toggle="modal" data-type="reply"
                                                data-parent="{{ $message[0]->parent_id }}"
                                                data-target="#modal-messaging">Reply</a></p>
                                    </div>
                                @else
                                    <div class="b-all p-20">
                                        <p class="p-b-20">click here to <a href="#" class="reply"
                                                data-toggle="modal" data-type="reply" data-parent="{{ $message[0]->id }}"
                                                data-target="#modal-messaging">Reply</a></p>
                                    </div>
                                @endif

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

                    <form method="POST" action="{{ route('message.save') }}" enctype="multipart/form-data"
                        id="sendrequest">
                        @csrf
                        <input type="text" name="type" id="reqtype" value="" hidden>
                        <input type="text" name="parentid" id="parentid" value="" hidden>
                        <div class="row">
                            <div class="form-group">
                                <input class="form-control" placeholder="Subject:" name="title" id="title">
                            </div>
                            <div class="form-group">
                                <select name="category" id="cat" class="form-control">
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
        </div> {{-- Modal Body --}}

    </div>
    <script type="text/javascript" src=" {!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>

    <script>
        $(document).ready(function(e) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });
            $(document).on("click", ".reply", function(e) {
                var type = $(this).attr("data-type");
                console.log(type);
                if (type == "reply") {
                    var parent = $(this).attr("data-parent");
                    $('.modal-title').text('Reply Request')
                    $('#reqtype').val('reply');
                    $('#parentid').val(parent);
                    $('#title').css('display', 'none');
                    $('#cat').css('display', 'none');
                } else {
                    $('#title').css('display', 'block');
                    $('#cat').css('display', 'block');
                }
            });

            $("#modal-messaging").on('show.bs.modal', function() {

            });
        });
    </script>
@endsection
