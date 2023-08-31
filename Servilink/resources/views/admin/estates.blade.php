@extends('layouts.manager')
@section('title', 'Estates Management')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Estates</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Registered Estate</h3>
                        <ul class="list-inline two-part">
                            <li><span class="t_resident">{{ count($estates) }}</span></li>
                        </ul>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">

                        <div class="row ">
                            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                <div class="panel-heading">Estates List</div>
                            </div>

                            <!-- /.col-lg-12 -->
                        </div>
                        <div class="table-responsive" style="padding-left: 10px;padding-right: 10px">
                            <table class="table table-hover" id="estatelist">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Manager</th>
                                        <th>Residents Count</th>
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
    <div class="modal fade" id="modal-estate" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Update estate account </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" enctype="multipart/form-data" id="update-estate">
                        @csrf
                        <input type="hidden" id="id" name="id" value="">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div>
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus
                                        placeholder="Estate Name">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>



                            <div class="form-group col-md-12">

                                <div>
                                    <input id="address" type="text"
                                        class="form-control @error('address') is-invalid @enderror" name="address"
                                        value="{{ old('address') }}" required placeholder="Address" autofocus>

                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <div>
                                    <input id="service_charge" type="number"
                                        class="form-control @error('service_charge') is-invalid @enderror"
                                        name="service_charge" value="{{ old('service_charge') }}"
                                        placeholder="Service Charge" autofocus>
                                    @error('service_charge')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-lg btn-info" id="updateestate" type="submit">
                        Submit
                    </button>
                </div>
                </form>
            </div>
        </div> {{-- Modal Body --}}

    </div> {{-- End Modal Dialog --}}

    <script src="{{ asset('dash/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>

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
                        url: "{{ route('estate.delete') }}",
                        method: 'POST',
                        data: {
                            id: id
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

            $(document).on("click", ".edit", function(e) {
                var id = $(this).attr("data-id");

                $.ajax({
                    method: 'GET',
                    url: "{{ route('show.estate') }}",
                    data: {
                        id: id,
                    },
                    success: function(response) {
                        var data = response;
                        $('.modal-body  #id').val(id);
                        $('.modal-body  #name').val(data.name);
                        $('.modal-body  #address').val(data.address);
                        $('.modal-body  #service_charge').val(data.service_charge);

                        $("#modal-estate").modal('show')
                    }
                });

            });

            $('#update-estate').submit(function(e) {
                e.preventDefault();
                var url = '{{ route('edit.estate') }}';

                let form = $('#update-estate').serialize();
                $.ajax({
                    method: 'POST',
                    url: url,
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
                        $("#modal-estate").modal('hide')
                    }
                });
            });




            var estate_list = $("#estatelist").DataTable({
                processing: true,
                serverSide: true,
                "ordering": false,
                "ajax": {
                    "url": '{{ route('estates') }}',

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
                        data: "manager",
                        name: "manager",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform", "sorting_1");
                        }
                    }

                    ,

                    {
                        data: "resident",
                        name: "resident",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform", "sorting_1");
                        }
                    }, {
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
@endsection
