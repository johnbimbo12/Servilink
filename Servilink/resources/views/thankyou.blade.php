@extends('layouts.loginapp')
@section('title', 'Thank you')
@section('content')
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="container">
                    <div class="row align-items-center justify-content-center">
                        <div style="text-align: center;">
                            <h2 style="font-weight:bold; color: black">Thanks for using our service</h2>
                            @if ($status=='error')
                              <h4 style="color: orange;margin-top: 10px">Transaction Fail !!!</h4>
                            @endif
                            <h4 style="color: white;margin-top: 15px;margin-bottom: 15px">{{ $msg }}</h4>
                            <a href="{{ route('instantpay') }}" class="align-items-center justify-content-center">

                                <div class="container-login100-form-btn col">
                                    <button type="submit" class="login100-form-btn">
                                        {{ __('Go Back') }}
                                    </button>

                                </div>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
