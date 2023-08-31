@extends('layouts.loginapp')
@section('title', 'Sign In')
@section('content')

    <div class="limiter" >
        <div class="container-login100" >
            <div class="wrap-login100">
                @include('theme.flash-messages')
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <span class="login100-form-logo">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('img/logo.png') }}" alt="home"
                            class="dark-logo" width="50" height="50" />
                        </a>
                        
                    </span>

                    <span class="login100-form-title p-b-34 p-t-27">
                        Log in
                    </span>

                    <div class="wrap-input100 validate-input" data-validate="Enter email address">
                        <input id="email" type="email" class="input100 @error('email') is-invalid @enderror" name="email"
                            value="" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="focus-input100" data-placeholder="&#xf207;"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Enter password">
                        <input id="password" type="password" class="input100 @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password" value="">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="focus-input100" data-placeholder="&#xf191;"></span>
                    </div>

                    <div class="contact100-form-checkbox">
                        <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
                        <label class="label-checkbox100" for="ckb1">
                            Remember me
                        </label>
                    </div>
                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn">
                            {{ __('Login') }}
                        </button>

                    </div>

                    <div class="text-center p-t-20">
                        @if (Route::has('password.request'))
                            <a class="txt1" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                    <ul class="text-center list-inline p-t-50" style="color: white">
                        <li class="list-inline-item">* Monitoring </li>
                        <li class="list-inline-item">* Control</li>
                        <li class="list-inline-item">* Virtualization</li>
                        <li class="list-inline-item">* Reporting</li>
                    </ul>
                </form>
            </div>
          
        </div>
      
    </div>

@endsection
