<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav slimscrollsidebar">
        <div class="sidebar-head">
            <h3><span class="fa-fw open-close"><i class="ti-menu hidden-xs"></i><i class="ti-close visible-xs"></i></span>
                <span class="hide-menu">Navigation</span>
            </h3>
        </div>
        <ul class="nav" id="side-menu">

            @if (Auth::user()->role == 1)
                <li> <a href="{{ route('dashboard') }}" class="waves-effect"><i class="mdi mdi-home fa-fw"
                            data-icon="v"></i> <span class="hide-menu"> Dashboard <span
                                class="fa arrow"></span></span></a>
                </li>
            @else
                <li> <a href="{{ route('dashboard') }}" class="waves-effect"><i class="mdi mdi-home fa-fw"
                            data-icon="v"></i> <span class="hide-menu"> Home <span
                                class="fa arrow"></span></span></a>
                </li>
            @endif
            <li class="devider"></li>

            @if (Auth::user()->role == 1)
                <li> <a href="{{ route('managers') }}" class="waves-effect"><i
                            class="mdi mdi-account-multiple fa-fw">
                        </i> <span class="hide-menu">Estate Managers
                            <span class="fa arrow"></span></span></a>
                </li>
                <li> <a href="{{ route('estates') }}" class="waves-effect"><i class="mdi mdi-home-map-marker fa-fw">
                        </i> <span class="hide-menu">Registered Estates
                            <span class="fa arrow"></span></span></a>
                </li>
                <li> <a href="{{ route('power.manage') }}" class="waves-effect"><i
                            class="mdi mdi-lightbulb-on fa-fw"></i> <span class="hide-menu">Power
                            Management<span class="fa arrow"></span></span></a>
                </li>
             
            @endif

            @if (Auth::user()->role == 2 || Auth::user()->role == 3)
                <li> <a href="{{ route('residents') }}" class="waves-effect"><i
                            class="mdi mdi-account-multiple fa-fw">
                        </i> <span class="hide-menu">Residents
                            <span class="fa arrow"></span></span></a>
                </li>
                <li> <a href="{{ route('manage.estate') }}" class="waves-effect"><i
                            class="mdi mdi-home-map-marker fa-fw">
                        </i> <span class="hide-menu">Manager's Estate
                            <span class="fa arrow"></span></span></a>
                </li>
                <li> <a href="#" class="waves-effect"><i class="mdi mdi-gas-station fa-fw"></i> <span
                            class="hide-menu">Diesel Management<span class="fa arrow"></span></span></a>
                </li>
            @endif

            @if (Auth::user()->role == 2)
                <li> <a href="{{ route('index.security') }}" class="waves-effect"><i
                            class="mdi mdi-security-home fa-fw">
                        </i> <span class="hide-menu">Security
                            <span class="fa arrow"></span></span></a>
                </li>

                <li> <a href="{{ route('index.space') }}" class="waves-effect"><i class="mdi mdi-store fa-fw">
                        </i> <span class="hide-menu">Space Lets
                            <span class="fa arrow"></span></span></a>
                </li>
                <li> <a href="{{ route('index.booking') }}" class="waves-effect"><i class="mdi mdi-cart fa-fw">
                        </i> <span class="hide-menu">Bookings
                            <span class="fa arrow"></span></span></a>
                </li>
            @endif
            @if (Auth::user()->role == 2 || Auth::user()->role == 4 || Auth::user()->role == 3)
                <li> <a href="{{ route('power.manage') }}" class="waves-effect"><i
                            class="mdi mdi-lightbulb-on fa-fw"></i> <span class="hide-menu">Power
                            Management<span class="fa arrow"></span></span></a>
                </li>
              
                <li> <a href="{{ route('visitor.manage') }}" class="waves-effect"><i
                            class="mdi mdi-account-switch fa-fw"></i> <span class="hide-menu">Visitor's
                            Management<span class="fa arrow"></span></span></a>
                </li>

                <li> <a href="{{ route('service.charges') }}" class="waves-effect"><i class="mdi mdi-worker fa-fw">
                        </i> <span class="hide-menu">Service Fee
                            <span class="fa arrow"></span></span></a>
                </li>
            @endif

            @if (Auth::user()->role == 4)
                <li> <a href="{{ route('index.booking') }}" class="waves-effect"><i class="mdi mdi-store fa-fw">
                        </i> <span class="hide-menu">Space Booking
                            <span class="fa arrow"></span></span></a>
                </li>
                <li> <a href="#household" class="waves-effect"><i class="mdi mdi-cart fa-fw"></i> <span
                            class="hide-menu">Household store<span class="fa arrow"></span></span></a>
                </li>
                <li> <a href="{{ route('transactions') }}" class="waves-effect"><i class="mdi mdi-history fa-fw">
                        </i> <span class="hide-menu">Transaction History
                            <span class="fa arrow"></span></span></a>
                </li>
            @endif

            @if (Auth::user()->role == 2 || Auth::user()->role == 4)
                <li> <a href="{{ route('messaging') }}" class="waves-effect">
                        <i class="mdi mdi-wechat fa-fw">
                        </i> <span class="hide-menu">Messaging
                            <span class="fa arrow"></span></span></a>

                </li>
                <li> <a href="{{ route('emergency') }}" class="waves-effect">
                    <i class="mdi mdi-alert-outline fa-fw">
                    </i> <span class="hide-menu">Emergency
                        <span class="fa arrow"></span></span></a>

            </li>
            @endif

            @if (Auth::user()->role == 1)
                <li> <a href="{{ route('revenue') }}" class="waves-effect"><i class="mdi mdi-arrow-compress fa-fw">
                        </i> <span class="hide-menu">Revenue Management
                            <span class="fa arrow"></span></span></a>
                </li>
            @endif
            @if (Auth::user()->role == 2 || Auth::user()->role == 3)
                <li> <a href="{{ route('transactions') }}" class="waves-effect"><i
                            class="mdi mdi-arrow-compress fa-fw">
                        </i> <span class="hide-menu">Revenue Management
                            <span class="fa arrow"></span></span></a>
                </li>
            @endif
            @if (Auth::user()->role == 3)
                <li> <a href="{{ route('setting') }}" class="waves-effect"><i class="mdi mdi-settings fa-fw">
                        </i> <span class="hide-menu">Settings
                            <span class="fa arrow"></span></span></a>
                </li>
            @endif
            <li class="devider"></li>
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();document.getElementById('logout-form1').submit();">
                    <i class="mdi mdi-logout fa-fw"></i>
                    Log out
                </a>
                <form id="logout-form1" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>
