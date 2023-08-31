@extends('layouts.manager')
@section('title', 'Settings')
@section('content')

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Setting</h4>
            </div>
        </div>
       
        <!-- .row -->
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <div class="white-box">
                   
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#account" aria-controls="account" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"> Account</span></a></li>
                        <li role="presentation" class=""><a href="#security" aria-controls="security" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Security</span></a></li>
                            </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="account">
                            <div class="col-md-6">
                                <h3>Account Setting</h3>
                                <h4>you can use it with the small code</h4> </div>
                            <div class="col-md-5 pull-right">
                                <p>Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a.</p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="security">
                            <div class="col-md-6">
                                <h3>Security Setting</h3>
                                <h4>you can use it with the small code</h4> </div>
                            <div class="col-md-5 pull-right">
                                <p>Vulputate eget, arcu, fringilla vel, aliquet nec, daf adfd vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a.</p>
                            </div>
                            <div class="clearfix"></div>
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