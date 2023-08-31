<nav class="navbar navbar-default navbar-static-top m-b-0">
    <div class="navbar-header">
        <div class="top-left-part">
            <a class="logo" href="/">
                <!-- Logo -->
                <!--This is dark logo icon--><img src="{{ asset('img/favicon-32x32.png') }}" alt="home"
                    class="dark-logo" />
                <!--This is light logo icon--><img src="{{ asset('img/favicon-32x32.png') }}" alt="home"
                    class="light-logo" />
                </b>
                <!-- Logo text image you can use text also --><span class="hidden-xs" style="color: black"> Servilink
                </span>
            </a>
        </div>
        <ul class="nav navbar-top-links navbar-left">
            <li><a href="javascript:void(0)" class="open-close waves-effect waves-light"><i class="ti-menu"></i></a></li>

            <!--<li class="dropdown">-->
            <!--    <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="{{route('messaging')}}"> <i class="mdi mdi-gmail"></i>-->
            <!--        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>-->
            <!--    </a>-->

            <!--</li>-->



            @if (Auth::user()->role == 4)
            <li style="margin-left:10px"><a href="javascript:void(0)" class="open-close waves-effect waves-light" style="font-weight: bolder; font-size: 18px; color:black"><i class="mdi mdi-wallet fa-fw"></i>: ₦ {{Auth::user()->estateuser->wallet_balance}}</a></li>
            
            @elseif (Auth::user()->role == 1)
            <li style="margin-left:10px"><a href="javascript:void(0)" class="open-close waves-effect waves-light" style="font-weight: bolder; font-size: 18px; color:black"><i class="mdi mdi-wallet fa-fw"></i>: ₦ {{$wallet}} <span style="font-size: 10px"> ( For admin vend)</span></a></li>
            @endif
           
            <!-- .Task dropdown -->

        </ul>
        <ul class="nav navbar-top-links navbar-right pull-right">

            <li class="dropdown">
                <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img
                        src="{{ asset('dash/plugins/images/users/varun.jpg') }}" alt="user-img" width="36"
                        class="img-circle"><b class="hidden-xs">{{ Auth::user()->name }}</b><span
                        class="caret"></span> </a>
                <ul class="dropdown-menu dropdown-user animated flipInY">
                    <li>
                        <div class="dw-user-box">
                            <div class="u-img"><img src="{{ asset('dash/plugins/images/users/varun.jpg') }}"
                                    alt="user" /></div>
                            <div class="u-text">
                                <h4>{{ Auth::user()->name }}</h4>
                                <p class="text-muted">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li><a href="#" data-toggle="modal" data-target="#changepassword"><i class="ti-settings"></i>
                            Change Password</a></li>
                    <li role="separator" class="divider"></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form3').submit();">
                            <i class="fa fa-power-off"></i>
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form3" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
    </div>
    <!-- /.navbar-header -->
    <!-- /.navbar-top-links -->
    <!-- /.navbar-static-side -->
</nav>
