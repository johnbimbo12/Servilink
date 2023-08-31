@extends('layouts.user')
@section('title', 'Emergency Contacts')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Emergency contacts</h4>
                </div>
            </div>

            @include('theme.flash-messages')

            <div class="row">
                <div class="col-md-12">
                    <div class="panel"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">

                        <div class="row ">
                            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                <div class="panel-heading">List</div>
                            </div>
                            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                                <button style="border-radius: 10px;padding: 10px;;margin:10px" type="button" id="createcontact"
                                    data-toggle="modal" data-target="#modal-add-contact"
                                    class="btn btn-danger pull-right m-l-20 waves-effect waves-light">Add Contact
                                    Account</a>
                            </div>
                            <!-- /.col-lg-12 -->
                        </div>
                        <div class="table-responsive" style="padding-left: 10px;padding-right: 10px">
                            <table class="table table-hover" id="contact">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Phone Number</th>
                                        <th>Action</th>
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
    <div class="modal fade" id="modal-add-contact" role="dialog" data-backdrop="static" data-keyboard="false"
        aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-12">
                        <h4 class="modal-title" id="myModalLabel">Add Emergency Contact</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="position: relative; top:-30px"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <div class="modal-body">
                    <form method="POST" action="#" enctype="multipart/form-data" id="create-contact">
                        @csrf
                        <div class="row">

                            <input type="hidden" id="data_id" value="0" name="id">
                            <div>
                                <div class="form-group col-md-12">
                                    <div>
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="contact_name" value=""
                                            required autocomplete="name" autofocus placeholder="Contact Name">

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group col-md-12">
                                    <div>
                                        <input id="contact_number" type="number"
                                            class="form-control @error('total_allocation') is-invalid @enderror"
                                            name="contact_phone" value="" required autofocus placeholder="Contact Number">

                                        @error('contact_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
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
        </div> {{-- Modal Body --}}
    </div>

    <script src="{{ asset('dash/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>

    <script>
        $(document).ready(function(e) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });

            $('#create-contact').submit(function(e) {
                e.preventDefault()
                let form = $('#create-contact').serialize();
                var url = "{{ route('store.contact') }}";
                if ($('#data_id').val() !== "0") {
                    url = "{{ route('edit.contact') }}";
                }
                $.ajax({
                    method: 'POST',
                    url: url,
                    data: form,
                    success: function(response) {
                        if (response.status = "ok") {
                            $("#contacts")
                                .DataTable()
                                .draw(true);
                            contacts.ajax.reload(null, false);
                        }
                        toastr.success(response.Message, {
                            timeOut: 5000
                        });
                        $("#modal-add-contact").modal('hide')
                    }
                });
            });


            $(document).on("click", "#createcontact", function(e) {
                $("#create-contacts").trigger("reset");
            });

            $(document).on("click", ".edit", function(e) {
                var id = $(this).attr("data-id");
                $.ajax({
                    method: 'GET',
                    url: "{{ route('show.contact') }}",
                    data: {
                        id: id,
                    },
                    success: function(response) {
                        $('.modal-title').text("Edit Contact Details");
                        $('.modal-body  #data_id').val(id);
                        var data = response;                       
                        $('.modal-body  #name').val(data.contact_name);
                        $('.modal-body  #conact_number').val(data.contact_phone);
                        $("#modal-add-contact").modal('show')
                    }
                });

                return false;
            });

            $(document).on("click", ".delete", function(e) {
                var id = $(this).attr("data-id");
                if (confirm("Are you sure?")) {
                    $.ajax({
                        url: "{{ route('delete.contact') }}",
                        method: 'POST',
                        data: {
                            id: id
                        },
                        success: function(res) {
                            contacts.ajax.reload(null,
                                false);
                            toastr.success('Contact account Deleted', {
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

            var contacts = $("#contact").DataTable({
                processing: true,
                serverSide: true,
                "ordering": false,
                "ajax": {
                    "url": "{{ route('emergency') }}",
                },
                          
                columns: [{
                        data: "contact_name",
                        name: "contact_name",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform", "sorting_1");
                        }
                    },

                    {
                        data: "contact_phone",
                        name: "contact_phone",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform", "sorting_1");
                        }
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
@endsection
