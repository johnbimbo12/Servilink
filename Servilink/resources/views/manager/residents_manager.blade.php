@extends('layouts.manager')
@section('title', 'Residents Management')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Resident Management</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Residents</h3>
                        <ul class="list-inline two-part">
                            <li><span class="t_resident">0</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Total Debtor</h3>
                        <ul class="list-inline two-part">
                            <li><span class="t_debtor">0</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            @include('theme.flash-messages')

            <div class="row">
                <div class="col-md-12">
                    <div class="panel"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">

                        <div class="row ">
                            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                <div class="panel-heading">RESIDENTS</div>
                            </div>
                            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                                <button style="border-radius: 10px;padding: 10px;;margin:10px" type="button" id="createuser"
                                    data-toggle="modal" data-target="#modal-add-user"
                                    class="btn btn-danger pull-right m-l-20 waves-effect waves-light">Create
                                    resident account</a>
                            </div>
                            <!-- /.col-lg-12 -->
                        </div>
                        <div class="table-responsive" style="padding-left: 10px;padding-right: 10px">
                            <table class="table table-hover" id="estateuser">
                                <thead>
                                    <tr>
                                        <th style="width: 150px;">Name</th>
                                        <th>Estate</th>
                                        <th>House NO.</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Meter Number</th>
                                        <th>Outstanding Payment</th>
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
    @include('modal.create-user')
    @include('modal.edit-user')
    <script src="{{ asset('dash/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>

    <script>
        $(document).ready(function(e) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });


            $(document).on("click", "#single", function() {
                $('#create-regular').css("display", "block");
                $('#templateupload').css("display", "none");
            
            });

            $(document).on("click", "#buck", function() {
                $('#create-regular').css("display", "none");
                $('#templateupload').css("display", "block");
               
            });

            $(document).on("click", "#upload", function() {
                $('#upload').text("Uploading, please wait...");
            });


            loadCardDetails();

            function loadCardDetails() {
                $.ajax({
                    method: "GET",
                    url: "{{ route('loadstat') }}",
                    success: function(msg) {
                        var tresident = (msg.tresidents);
                        var debtor = (msg.debtors);
                        $(".t_resident").text(tresident);
                        $(".t_debtor").text(debtor);
                    },

                });
            }

            $('#create-regular').submit(function(e) {
                e.preventDefault()
                let form = $('#create-regular').serialize();
                $.ajax({
                    method: 'POST',
                    url: '/registeruser',
                    data: form,
                    success: function(response) {
                        if (response.status = "ok") {
                            $("#estateuser")
                                .DataTable()
                                .draw(true);
                            estate_user.ajax.reload(null, false);
                        }
                        toastr.success(response.Message, {
                            timeOut: 5000
                        });
                        loadCardDetails();
                        $("#modal-add-user").modal('hide')
                    }
                });
            });


            $("#modal-add-user").on("show.bs.modal", function(e) {
                $("#create-regular").trigger("reset");
                $('#ispaid').css('display', 'none')
            });




            $('#modal-edit-resident').on('show.bs.modal', function(e) {
                var id = $(e.relatedTarget).data('id');
                $.ajax({
                    method: 'GET',
                    url: "{{ route('show.resident') }}",
                    data: {
                        id: id,
                    },
                    success: function(response) {
                        var data = response.data;
                        $('.modal-body  #fullnameedit').val(data.name);
                        $('.modal-body  #emailedit').val(data.email);
                        $('.modal-body  #phoneedit').val(data.phonenumber);
                        $('.modal-body  #housenumedit').val(data.housenum);
                        $('.modal-body  #meterpanedit').val(data.meternumber);
                        $('.modal-body  #waternoedit').val(data.waternumber);
                        var enable = data.status;
                        if (enable == 1) {
                            $(".modal-body #status option[value=1]").attr('selected', true);
                            $(" .modal-body #status option[value=0]").attr('selected', false);
                        } else if (enable == 0) {
                            $(" .modal-body #status option[value=0]").attr('selected', true);
                            $(" .modal-body #status option[value=1]").attr('selected', false);
                        }
                        $('.modal-body  #data_id').val(data.id);
                    }
                });
            });


            $("#edit-resident").submit(function(e) {
                e.preventDefault();
                let form = $("#edit-resident").serialize();
                $.ajax({
                    method: "POST",
                    url: "/editresident",
                    data: form,
                    success: function(response) {
                        if (response['status'] == "ok") {
                            $("#estateuser").DataTable().draw(true);
                            estate_user.ajax.reload(null,
                                false); // user paging is not reset on reload
                            toastr.success("Resident data updated successfully", {
                                timeOut: 5000
                            });

                        } else {
                            toastr.warning('User update fails', {
                                timeOut: 5000
                            });
                        }

                        $("#modal-edit-resident").modal("hide");
                    },
                    error: function(data) {
                        toastr.warning('Error occur', {
                            timeOut: 5000
                        });
                        $("#modal-edit-resident").modal("hide");
                    }
                });
            });

            $(document).on("click", ".delete", function(e) {
                var id = $(this).attr("data-id");

                if (confirm("Are you sure?")) {
                    $.ajax({
                        url: "{{ route('delete.account') }}",
                        method: 'POST',
                        data: {
                            id: id
                        },
                        success: function(res) {
                            estate_user.ajax.reload(null,
                                false);
                            toastr.success('Resident Deleted', {
                                timeOut: 5000
                            });
                            loadCardDetails();
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
            $('#checkpaid').change(function() {
                if (this.checked) {
                    $('#ispaid').css('display', 'block')
                } else {
                    $('#ispaid').css('display', 'none')
                }

            });


            var estate_user = $("#estateuser").DataTable({
                processing: true,
                serverSide: true,
                "ordering": false,
                "ajax": {
                    "url": '{{ route('load.resident') }}',

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
                    }, {
                        data: "housenum",
                        name: "housenum",
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
                        data: "meternumber",
                        name: "meternumber",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform");
                        },

                    },
                    {
                        data: "pay_status",
                        name: "pay_status",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform");
                        },

                    },
                    {
                        data: "lock_status",
                        name: "lock_status",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform", "center");
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
@endsection
