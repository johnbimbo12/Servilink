@extends('layouts.manager')
@section('title', 'Settings')
@section('content')

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">System Setting</h4>
                </div>
            </div>

            <!-- .row -->
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="white-box">
                        @include('theme.flash-messages')

                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#account" aria-controls="account"
                                    role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i
                                            class="ti-home"></i></span><span class="hidden-xs">
                                        Account</span></a></li>
                            <li role="presentation" class=""><a href="#security" aria-controls="security"
                                    role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i
                                            class="ti-user"></i></span> <span
                                        class="hidden-xs">Security</span></a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="account">
                                <div class="">
                                    <h3>Account Setting</h3>
                                    <h4>Update your settlement account details</h4>
                                </div>
                                <div class="col">
                                    <form method="POST" action="{{route('update.bank')}}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="" id="operation" value="add">
                                        <input type="hidden" name="user_id" id="userid" value="">
                                        <div class="row">

                                            <div class="form-group col-md-12">
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label for="" style="font-size: 12px">Power Utility Account
                                                            Details</label>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <input id="power" type="text" class="form-control"
                                                                    name="powerbankname" value="{{$settings->pbank}}" max="10"
                                                                    placeholder="Bank Name">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <input id="power" type="text" class="form-control"
                                                                    name="power" value="{{$settings->pnuban}}" max="10"
                                                                    placeholder="NUBAB Number">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label style="font-size: 12px" for="">Sevice Charge Account
                                                            Details</label>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <input id="power" type="text" class="form-control"
                                                                    name="servicebankname" value="{{$settings->sbank}}" max="10"
                                                                    placeholder="Bank Name">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <input id="service" type="text" class="form-control"
                                                                    name="service" value="{{$settings->snuban}}" max="10"
                                                                    placeholder="NUBAN Number">
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="form-group col-md-12">
                                                        <label style="font-size: 12px" for="">Water Utility Account
                                                            Details</label>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <input id="water" type="text" class="form-control"
                                                                    name="waterbankname" value="{{$settings->wbank}}" max="10"
                                                                    placeholder="Bank Name">
                                                            </div>
                                                            <div class="col-lg-6">

                                                                <input id="water" type="text" class="form-control"
                                                                    name="water" value="{{$settings->wnuban}}" placeholder="NUBAN Number">

                                                            </div>
                                                        </div>

                                                    </div>


                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-lg btn-info" id="saveresident" type="submit">
                                                Update
                                            </button>
                                        </div>
                                    </form>
                                </div>
                          
                            </div>
                            <div role="tabpanel" class="tab-pane" id="security">
                                <div class=modal-footer">
                                    <h3>Profile Setting</h3>
                                </div>
                                <div>
                                    <form method="POST" action="{{route('update.account')}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="name"
                                                    class="col-form-label">{{ __('Name') }}</label>
                                                <div>
                                                    <input id="name" type="text"
                                                        class="form-control" value="{{$settings->name}}"
                                                        name="name">                                                 
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email"
                                                    class="col-form-label">{{ __('Email Address') }}</label>
                                                <div>
                                                    <input id="email" type="text"
                                                        class="form-control" value="{{$settings->email}}"
                                                        name="email">

                                                  
                                                </div>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="Phone number"
                                                    class="col-form-label">{{ __('Phone number') }}</label>

                                                <div>
                                                    <input id="phonenumber" type="phone" class="form-control" value="{{$settings->phonenumber}}"
                                                        name="phonenumber">
                                                </div>
                                            </div>

                                           
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-lg btn-info" type="submit">
                                                Update
                                            </button>
                                        </div>
                                    </form>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
        <footer class="footer text-center"><?php echo date('Y'); ?> &copy;
            Servilink. All
            Rights
            Reserved. </footer>
    </div>

@endsection
