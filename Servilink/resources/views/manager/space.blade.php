@extends('layouts.manager')
@section('title', 'Space Management')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Space Rental</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Total space</h3>
                        <ul class="list-inline two-part">
                            <li><span class="tspace">{{$tspace}}</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Booked space</h3>
                        <ul class="list-inline two-part">
                            <li><span class="booked">{{$booked}}</span></li>
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
                                <div class="panel-heading">List</div>
                            </div>
                            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                                <button style="border-radius: 10px;padding: 10px;;margin:10px" type="button" id="createuser"
                                    data-toggle="modal" data-target="#modal-add-space"
                                    class="btn btn-danger pull-right m-l-20 waves-effect waves-light">Add Space</a>
                            </div>
                            <!-- /.col-lg-12 -->
                        </div>
                        <div class="table-responsive" style="padding-left: 10px;padding-right: 10px">
                            <table class="table table-hover" id="space">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Amount</th>
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
    <div class="modal fade" id="modal-add-space" role="dialog" data-backdrop="static" data-keyboard="false"
        aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-12">
                        <h4 class="modal-title" id="myModalLabel">Create space</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="position: relative; top:-30px"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <div class="modal-body">
                    <form method="POST" action="#" enctype="multipart/form-data" id="create-space">
                        @csrf
                        <div class="row">
                          
                            <input type="hidden" id="data_id" value="0" name="id">
                            <div>
                                <div class="form-group col-md-12">
                                    <div>
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name" value=""
                                            required autocomplete="name" autofocus placeholder="Space Name">

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <div>
                                        <input id="amount" type="number"
                                            class="form-control @error('amount') is-invalid @enderror" name="amount" value=""
                                            required  autofocus placeholder="Amount">

                                        @error('amount')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                             

                                <div class="form-group col-md-12">
                                    <select name="estate" id="estate"
                                        class="form-control @error('estate') is-invalid @enderror" required>
                                        <option value="0">Select Estate</option>
                                        @foreach ($estates as $estate)
                                            <option value="{{ $estate->id }}">
                                                {{ $estate->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('estate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <span class="focus-input100" data-placeholder="&#xf207;"></span>
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

            $('#create-space').submit(function(e) {
                e.preventDefault()
                let form = $('#create-space').serialize();
                var url = "{{ route('store.space') }}";
                if ($('#data_id').val() !== "0") {
                    url = "{{ route('edit.space') }}";
                }
                $.ajax({
                    method: 'POST',
                    url: url,
                    data: form,
                    success: function(response) {
                        if (response.status = "ok") {
                            $("#estatespace")
                                .DataTable()
                                .draw(true);
                            space.ajax.reload(null, false);
                        }
                        toastr.success(response.Message, {
                            timeOut: 5000
                        });
                        $("#modal-add-space").modal('hide')
                    }
                });
            });


            $(document).on("click", "#createspace", function(e) {
                $("#create-space").trigger("reset");
                $(".modal-body #estate option[value=0]").attr('selected', true);
                $('.modal-body  #status').attr("checked", false);
            });

            $(document).on("click", ".edit", function(e) {
                var id = $(this).attr("data-id");
                $.ajax({
                    method: 'GET',
                    url: "{{ route('show.space')}}",
                    data: {
                        id: id,
                    },
                    success: function(response) {
                        $('.modal-title').text("Edit Space Details");
                        $('.modal-body  #data_id').val(id);
                        var data = response;
                        console.log(data.name)
                        $('.modal-body  #name').val(data.name);
                        $('.modal-body  #amount').val(data.cost);
                        $('.modal-body  #total_allocation').val(data.total_allocation);
                        $(".modal-body #estate option[value=" + data.estate_id + "]").attr(
                            'selected', true);
                        $('.modal-body  #data_id').val(data.id);
                        $("#modal-add-space").modal('show')
                    }
                });

                return false;
            });

            $(document).on("click", ".delete", function(e) {
                var id = $(this).attr("data-id");
                if (confirm("Are you sure?")) {
                    $.ajax({
                        url: "{{ route('delete.space') }}",
                        method: 'POST',
                        data: {
                            id: id
                        },
                        success: function(res) {
                            space.ajax.reload(null,
                                false);
                            toastr.success('Space account Deleted', {
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

            var space = $("#space").DataTable({
                processing: true,
                serverSide: true,
                "ordering": false,
                "ajax": {
                    "url": "{{ route('index.space') }}",
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
                        data: "cost",
                        name: "cost",
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
