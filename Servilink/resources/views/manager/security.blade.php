@extends('layouts.manager')
@section('title', 'Estate Security')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Security Personnel</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <div class="white-box"
                        style="border-radius: 20px;padding: 15px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="box-title">Registered security</h3>
                        <ul class="list-inline two-part">
                            <li><span class="securitycnt">{{$cnt}}</span></li>
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
                                <button style="border-radius: 10px;padding: 10px;;margin:10px" type="button" id="createsecurity"
                                    data-toggle="modal" data-target="#modal-add-security"
                                    class="btn btn-danger pull-right m-l-20 waves-effect waves-light">Create Security
                                    Account</a>
                            </div>
                            <!-- /.col-lg-12 -->
                        </div>
                        <div class="table-responsive" style="padding-left: 10px;padding-right: 10px">
                            <table class="table table-hover" id="estatesecurity">
                                <thead>
                                    <tr>
                                        <th style="width: 150px;">Name</th>
                                        <th>Estate</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Status</th>
                                        <th style="width: 100px;">Action</th>
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
    <div class="modal fade" id="modal-add-security" role="dialog" data-backdrop="static" data-keyboard="false"
        aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-12">
                        <h4 class="modal-title" id="myModalLabel">Create security account </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="position: relative; top:-30px"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <div class="modal-body">
                    <form method="POST" action="#" enctype="multipart/form-data" id="create-security">
                        @csrf
                        <div class="row">
                            <input type="hidden" id="data_id" value="0" name="id">
                            <div>
                                <div class="form-group col-md-12">
                                    <div>
                                        <input id="fullname" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="" required autocomplete="name" autofocus
                                            placeholder="Full Name">

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <div>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="" required autocomplete="email" autofocus
                                            placeholder="Email Address">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group col-md-12">

                                    <div>
                                        <input id="phone" type="text"
                                            class="form-control @error('phone') is-invalid @enderror" name="phone"
                                            value="" autocomplete="phone" pattern=".{11,}" required
                                            title=" Minimum of 11 digits is require for a valid phone number"
                                            placeholder="Phone Number" autofocus>

                                        @error('phone')
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

                                <div class="form-group col-md-12">
                                     <label class="label-checkbox100" for="password">
                                      Password
                                    </label>
                                    <div>
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password"
                                            >
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                              
                
                                <div class="form-group col-md-12">
                                    <label class="label-checkbox100" for="status">
                                        Activate?
                                    </label>
                                    <input class="input-checkbox100" id="status" type="checkbox" name="status">

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
          
            $('#create-security').submit(function(e) {
                e.preventDefault()
                let form = $('#create-security').serialize();
                var url ="{{ route('store.security') }}";
                if($('#data_id').val() !== "0"){
                    url ="{{ route('edit.security') }}";
                }
                $.ajax({
                    method: 'POST',
                    url: url,
                    data: form,
                    success: function(response) {
                        if (response.status = "ok") {
                            $("#estatesecurity")
                                .DataTable()
                                .draw(true);
                            estate_security.ajax.reload(null, false);
                        }
                        toastr.success(response.Message, {
                            timeOut: 5000
                        });
                        $("#modal-add-security").modal('hide')
                    }
                });
            });


            $(document).on("click", "#createsecurity", function(e) { 
                $("#create-security").trigger("reset");
                $(".modal-body #estate option[value=0]").attr('selected', true);
                $('.modal-body  #status').attr("checked", false);
            });

            $(document).on("click", ".edit", function(e) {
                var id = $(this).attr("data-id");
                $.ajax({
                    method: 'GET',
                    url: "{{ route('show.security') }}",
                    data: {
                        id: id,
                    },
                    success: function(response) {
                        $('.modal-title').text("Edit Security Account");
                        $('.modal-body  #data_id').val(id);
                        var data = response;
                        console.log(data.name)
                        $('.modal-body  #fullname').val(data.name);
                        $('.modal-body  #email').val(data.email);
                        $('.modal-body  #phone').val(data.phonenumber);
                        $(".modal-body #estate option[value="+data.estate_id+"]").attr('selected', true);
                        var enable = "";
                        if(data.status==1){
                            $('.modal-body  #status').attr("checked",true);
                        }else{
                            $('.modal-body  #status').attr("checked", false);
                        }
                       
                        $('.modal-body  #data_id').val(data.id);
                        $("#modal-add-security").modal('show')
                    }
                });

                return false;
            });
         
            $(document).on("click", ".delete", function(e) {
                var id = $(this).attr("data-id");
                if (confirm("Are you sure?")) {
                    $.ajax({
                        url: "{{ route('delete.security') }}",
                        method: 'POST',
                        data: {
                            id: id
                        },
                        success: function(res) {
                            estate_user.ajax.reload(null,
                                false);
                            toastr.success('Security account Deleted', {
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

            var estate_security= $("#estatesecurity").DataTable({
                processing: true,
                serverSide: true,
                "ordering": false,
                "ajax": {
                    "url": "{{ route('load.security') }}",
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
                        data: "status",
                        name: "status",
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css("text-transform", "center");
                        },
                        render: function(data, type, row) {
                            if (data == 0) {
                                return "Disabled";
                            } 
                            else if (data == 1) {
                                return "Enabled";
                            }
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
