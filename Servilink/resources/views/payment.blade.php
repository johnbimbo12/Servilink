@extends('layouts.loginapp')
@section('title', 'Instant Service')
@section('content')

    <div class="limiter">
        <div class="container-login100">

            <div class="wrap-login100">
                <h5 class="d-none" id="info" style="margin-bottom:20px; color:white;text-align:center">NOTE: N50,000
                    Diesel Deposit will be add to your first purchase of the month</h5>
                @include('theme.flash-messages')
                <div class="row" id="selector" style="margin-bottom: 40px">

                    <div class="container-login100-form-btn col">
                        <button type="button" id="qPay" class="login100-form-btn">
                            {{ __('Quick Payment') }}
                        </button>

                    </div>
                    <div class="container-login100-form-btn col">
                        <a class="button login100-form-btn" href=" {{ route('login') }}">
                            <span class="logo-title" style="color: black; font-size: 18px;">{{ __('Dashboard') }}</span>
                        </a>
                    </div>
                </div>
                <hr style="color: white; width: 100%; height:10px;;font-weight: bolder">
                <form method="POST" action="{{ route('login') }}" id="loginform" class="d-none">
                    @csrf
                    <span class="login100-form-title p-b-34 p-t-27">
                        Log in
                    </span>

                    <div class="wrap-input100 validate-input" data-validate="Enter email address">
                        <input id="email" type="email" class="input100 @error('email') is-invalid @enderror"
                            name="email" value="" required autocomplete="off">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="focus-input100 fa" data-placeholder="&#xf207;"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Enter password">
                        <input id="password" type="password" class="input100 @error('password') is-invalid @enderror"
                            name="password" required value="">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="focus-input100" data-placeholder="&#xf191;"></span>
                    </div>

                    <div class="container-login100-form-btn col">
                        <button type="submit" class="login100-form-btn">
                            {{ __('  Login  ') }}
                        </button>
                    </div>
                    <ul class="text-center list-inline p-t-50" style="color: white">
                        <li class="list-inline-item">* Monitoring </li>
                        <li class="list-inline-item">* Control</li>
                        <li class="list-inline-item">* Virtualization</li>
                        <li class="list-inline-item">* Reporting</li>
                    </ul>
                </form>
                <div id="selectoption" class="d-none">
                    <span class="login100-form-title p-b-34 p-t-27">
                        Make Payment
                    </span>
                    <div class="wrap-input100 validate-input">
                        <select name="payselect" style="height: 50px; font-size: large;" id="payselect"
                            class=" form-control @error('payselect') is-invalid @enderror">
                            <option value="0">Select Payment</option>
                            <option value="1">Power purchase</option>
                            <option value="2">Service Fee</option>
                        </select>
                    </div>
                </div>
        
                <form method="POST" action="{{ route('purchaseunit') }}" id="buyunitform" class="d-none">
                    @csrf
                    <input type="text" hidden name="path" value="0">
                    <input type="text" hidden name="paytype" value="0">
                    <input type="text" hidden class="p_key" value="{{ $public_key }}">
                    <input type="text" hidden name="h_key" value="{{ $hinge_key }}">
                    <input type="text" hidden name="manager_id" value=""  class="manager_id">
                    <input type="text" hidden class="firstname" value="femi" name="first">
                    <input type="text" hidden class="lastname" value="john" name="last">
                    <input type="text" hidden name="product" id="product" value="power">
                    <input type="text" hidden name="operator" id="operator" value="servilink">
                    <input type="text" hidden class="customer_ref" name="customer_ref" value="">
                    <input type="text" hidden name="accountname" class="accountname" value="">
                    <input type="text" hidden name="accountnum" classs="accountnum" value="">
                    <input type="text" hidden class="bankname" name="bankname" value="">
                    <div>
                        <div class="wrap-input100 validate-input">
                            <select name="selectestate" style="height: 50px; font-size: large;" id="selectestate"
                                class="estateid form-control @error('selectestate') is-invalid @enderror">
                                <option value="0" data-id="0">Select Estate</option>
                                @foreach ($estates as $estate)
                                    <option value="{{ $estate->id }}" data-id="{{ $estate->id }}">
                                        {{ $estate->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="housenumber">
                        <input id="housenumber" type="text"
                            class=" housenumber input100 @error('housenumber') is-invalid @enderror" name="housenumber"
                            value="" required placeholder="House Number">
                        @error('housenumber')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="focus-input100" data-placeholder="&#xf175;"></span>
                    </div>
                    <div class="wrap-input100 validate-input d-none" data-validate="Meter Number">
                        <input id="meternumber" type="text"
                            class="meternumber input100 @error('meternumber') is-invalid @enderror" name="meternumber"
                            value="" required placeholder="Meter Number">
                    </div>
                    <div class="wrap-input100 validate-input d-none" data-validate="Email Address">
                        <input id="email" type="email" class="input100 email @error('email') is-invalid @enderror"
                            name="email" value="" required placeholder="Enter Email Address">
                    </div>
                    <div class="wrap-input100 validate-input d-none" data-validate="Phone Number">
                        <input id="phone" type="text" class="input100 phone @error('phone') is-invalid @enderror"
                            name="phone" value="" required placeholder="Enter phone number">
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Purchase Amount">
                        <input id="amount" type="number" class="input100  @error('amount') is-invalid @enderror"
                            name="amount" value="" required placeholder="Purchase amount" autofocus>

                        @error('amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="focus-input100" data-placeholder="₦"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Purchase Amount">
                        <label class="control-label" style="color:white; font-size:18px">Payment Method</label>
                        <div class="radio-list">
                            <div class="radio radio-info">
                                <label for="radio1" style="color: white"><input type="radio" name="paymethod"
                                        id="radio1" value="1" checked> Credit/ Debit Card</label>
                            </div>
                  
                        </div>
                    </div>
                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn" disabled id="powerbnt">
                            {{ __('Pay') }}
                        </button>

                    </div>

                </form>
                <form method="POST" action="{{ route('payprocess') }}" id="servicechargeform" class="d-none">
                    @csrf
                    <input type="hidden" name="path" value="0">
                    <input type="text" hidden class="p_key" value="{{ $public_key }}">
                    <input type="text" hidden name="h_key" value="{{ $hinge_key }}">
                    <input type="text" hidden class="firstname" value="femi" name="first">
                    <input type="text" hidden name="product" id="product" value="service">
                    <input type="text" hidden name="operator" id="operator" value="servilink">
                    <input type="text" hidden class="lastname" value="john" name="last">
                    <input type="text" hidden class="customer_ref" name="customer_ref" value="">
                    <input type="text" hidden name="manager_id" value="" class="manager_id">
                    <input type="text" hidden name="accountname" class="accountname" value="">
                    <input type="text" hidden name="accountnum" classs="accountnum" value="">
                    <input type="text" hidden class="bankname" name="bankname" value="">
                    <div class="wrap-input100 validate-input" data-validate="Select Estate">
                        <select name="estatesc" style="height: 50px; font-size: large" id="estatesc"
                            class="form-control @error('estatesc') is-invalid @enderror serviceestateid" required>
                            <option value="0"data-id="0">Select Estate</option>
                            @foreach ($estates as $estate)
                                <option value="{{ $estate->service_charge }}" data-id="{{ $estate->id }}">
                                    {{ $estate->name }}</option>
                            @endforeach
                        </select>
                        @error('estatesc')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="focus-input100" data-placeholder="&#xf207;"></span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="housenumber">
                        <input type="text"
                            class="servicehousenumber input100 @error('housenumber') is-invalid @enderror"
                            name="housenumber" value="" required placeholder="House Number">
                        @error('housenumber')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="focus-input100" data-placeholder="&#xf175;"></span>
                    </div>
                    <div class="wrap-input100 validate-input d-none" data-validate="Meter Number">
                        <input type="text"
                            class="servicemeternumber input100 @error('meternumber') is-invalid @enderror"
                            name="meternumber" value="" required placeholder="Meter Number" autocomplete="off">
                        @error('meternumber')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="focus-input100" data-placeholder="&#xf328;"></span>
                    </div>
                    <div class="wrap-input100 validate-input d-none" data-validate="Phone number">
                        <input type="text" class="servicephone input100 @error('name') is-invalid @enderror"
                            name="phonenumber" value="" required placeholder="Phone number" autocomplete="off">
                        @error('phone number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="focus-input100" data-placeholder="&#xf2be;"></span>
                    </div>

                    <div class="wrap-input100 validate-input d-none" data-validate="Email Address">
                        <input type="email" class="serviceemail input100 @error('email') is-invalid @enderror"
                            name="email" value="" required placeholder="Enter Email Address" autofocus
                            autocomplete="off">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="focus-input100" data-placeholder="&#xf159;"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Number of month">
                        <input id="nummonth" type="number" class="input100 @error('nummonth') is-invalid @enderror"
                            name="nummonth" value="" min="1" max="12" required
                            placeholder=" Number of months" autocomplete="off">
                        @error('nummonth')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="focus-input100" data-placeholder="&#xf204;"></span>
                    </div>

                    <input type="text" name="estateid" id="estateid" value="" class="d-none">
                    <input type="text" id="scamount" name="scamount" value="" class="d-none">
                    <div class="wrap-input100">
                        <label style="color: white" id="totalamt">
                        </label>
                    </div>

                    <div class="wrap-input100 validate-input">
                        <label class="control-label" style="color:white; font-size:18px">Payment Method</label>
                        <div class="radio-list">
                            <div class="radio radio-info">
                                <label for="radio1" style="color: white"><input type="radio" name="paymethodsc"
                                        id="radio1" value="1" checked> Credit/ Debit Card</label>
                            </div>
                          
                        </div>
                    </div>


                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn" disabled id="servicebtn">
                            {{ __('Pay') }}
                        </button>

                    </div>

                </form>
            </div>

        </div>

    </div>

@endsection
<script src="{{ asset('assets/js/jquery.js') }}"></script>
<script>
    $(document).ready(function(e) {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });

        $(window).keydown(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        $('#buyunitform').submit(function(e) {
            const valtext = $("#amount").val();
            if (valtext.length > 0) {
                $('#powerbnt').prop("disabled", false);
            } else {
                alert("Amount is required")
            }
            var method = $("input:radio[name ='paymethod']:checked").val();
            if (method == 2 || method == "2") {
                e.preventDefault();
                var formdata = $('#buyunitform').serialize();
                toastr.info('Customer verification...Please wait...')
               
                $.ajax({
                    method: 'GET',
                    url: "{{ route('verify.customer') }}",
                    data: formdata,
                    success: function(response) {
                        if (response.status == "ok") {
                            toastr.info('Redirecting to payment gateway...Please wait...')
                            let phonenumber = $('.phone').val();
                            if (phonenumber.substring(0, 4) == "+234") {
                                phonenumber = phonenumber;
                            } else if (phonenumber.substring(0, 3) == "234") {
                                phonenumber = "+" + phonenumber;
                            } else {
                                phonenumber = "+234" + phonenumber.substring(1);
                            }
                            window.sessionStorage.setItem("customer_ref", response.customer_ref);
                            $('.customer_ref').val(response.customer_ref);
                            $('.manager_id').val(response.manager_id);
                            $('.accountname').val(response.accountname);
                            $('.accountnum').val(response.accountnum);
                            $('.bankname').val(response.bankname);
                            const form = $(e.target);
                            const buyunitform = convertFormToJSON(form);
                            let handler = BaniPopUp({
                                amount: response
                                    .amount, //The amount the customer wants to pay
                                phoneNumber: phonenumber, //The mobile number of the customer in int format i.e +2348173709000
                                email: $('.email')
                            .val(), //The email of the customer
                                firstName: $('.firstname')
                            .val(), //The first name of the customer
                                lastName: $('.lastname')
                            .val(), //The last name of the customer
                                merchantKey: $('.p_key')
                            .val(), //The merchant Bani public key
                                metadata: buyunitform,
                                merchantRef: response.customer_ref,
                                onClose: (response) => {
                                    location.reload();
                                },
                                callback: function(response) {
                                    $.ajax({
                                        method: 'get',
                                        url: "{{ route('bani.verify') }}",
                                        data: {
                                            ref: response?.reference,
                                            type: response?.type,
                                            customer_ref:$('.customer_ref').val()
                                        },
                                        success: function(response) {
                                            window.sessionStorage.clear();
                                            window.location.href =
                                                response;
                                        },
                                        error: function() {
                                              window.sessionStorage.clear();
                                        }
                                    });
                                }
                            })
                            handler
                        } else {
                            location.reload();
                        }

                    },
                    error: function() {
                        window.sessionStorage.clear();
                    }
                });

            }


        });

        $('#servicechargeform').submit(function(e) {
            const valtext = $("#nummonth").val();
            if (valtext.length > 0) {
                $('#servicebtn').prop("disabled", false);
            } else {
                alert("Number of month is required")
            }
            var method = $("input:radio[name ='paymethodsc']:checked").val();
            if (method == 2 || method == "2") {
                e.preventDefault();
                var formdata = $('#servicechargeform').serialize();
                toastr.info('Customer verification...Please wait...')
                $.ajax({
                    method: 'GET',
                    url: "{{ route('verify.customer') }}",
                    data: formdata,
                    success: function(response) {
                        if (response.status == "ok") {
                            toastr.info('Redirecting to payment gateway...Please wait...')
                            let phonenumber = $('.servicephone').val();
                            if (phonenumber.substring(0, 4) == "+234") {
                                phonenumber = phonenumber;
                            } else if (phonenumber.substring(0, 3) == "234") {
                                phonenumber = "+" + phonenumber;
                            } else {
                                phonenumber = "+234" + phonenumber.substring(1);
                            }
                            $('.accountname').val(response.accountname);
                            $('.accountnum').val(response.accountnum);
                            $('.bankname').val(response.bankname);
                            $('.customer_ref').val(response.customer_ref);
                            $('.manager_id').val(response.manager_id);
                            window.sessionStorage.setItem("customer_ref", response.customer_ref);
                            const form = $(e.target);
                            const payfee = convertFormToJSON(form);
                            let handler = BaniPopUp({
                                amount: response
                                    .amount, //The amount the customer wants to pay
                                phoneNumber: phonenumber, //The mobile number of the customer in int format i.e +2348173709000
                                email: $('.serviceemail')
                                    .val(), //The email of the customer
                                firstName: $('.firstname')
                                    .val(), //The first name of the customer
                                lastName: $('.lastname')
                                    .val(), //The last name of the customer
                                merchantKey: $('.p_key')
                                    .val(), //The merchant Bani public key
                                metadata: payfee,
                                merchantRef: response.customer_ref,
                                onClose: (response) => {
                                    location.reload();
                                },
                                callback: function(response) {
                                    $.ajax({
                                        method: 'GET',
                                        url: "{{ route('bani.verify') }}",
                                        data: {
                                            ref: response?.reference,
                                            type: response?.type,
                                            customer_ref: $('.customer_ref').val()
                                        },
                                        success: function(response) {
                                              window.sessionStorage.clear();
                                            window.location.href =
                                                response;

                                        },
                                        error: function() {
                                              window.sessionStorage.clear();

                                        }
                                    });
                                }
                            })
                            handler
                        } else {
                            location.reload();
                        }
                    },
                    error: function() {
                         window.sessionStorage.clear();
                    }
                });
            }

        });

        function convertFormToJSON(form) {
            return $(form)
                .serializeArray()
                .reduce(function(json, {
                    name,
                    value
                }) {
                    json[name] = value;
                    return json;
                }, {});
        }
        $("#nummonth").change(function() {
            const valtext = $(this).val();
            if (valtext.length > 0) {
                $('#servicebtn').prop("disabled", false);
            } else {
                alert("Number of month is required")
                $('#servicebtn').prop("disabled", true);
            }
        });

        $("#amount").change(function() {
            const valtext = $(this).val();
            if (valtext.length > 0) {
                $('#powerbnt').prop("disabled", false);
            } else {
                $('#powerbnt').prop("disabled", true);
                alert("Amount is required")
            }
        });


        $('.housenumber').blur(function() {
            let id = $(".estateid").find("option:selected").attr('data-id');
            if (id == "0") {
                $('.housenumber').val("");
                alert("Please select Estate");
                return;
            }
            $.ajax({
                method: 'GET',
                url: "{{ route('getmeter') }}",
                data: {
                    estateid: id,
                    housenumber: $(this).val()
                },
                success: function(response) {
                    if (response.status == "ok") {
                        $('.email').val(response.email);
                        $('.phone').val(response.phone);
                        $('.firstname').val(response.firstName);
                        $('.lastname').val(response.lastName);
                        $('.meternumber').val(response.meternumber);
                         $('#buyunitform .manager_id').val(response.manager_id);
                        if (response.isdiesel > 0) {
                            $('#info').removeClass('d-none');
                            $('#info').text("NOTE: There is a pending  ₦" + response
                                .isdiesel +
                                " Diesel Deposit fee. This amount will be added to your purchase"
                                );
                        }
                        toastr.success("Resident found", {
                            timeOut: 5000
                        });
                    } else {
                        toastr.info("Resident not found", {
                            timeOut: 5000
                        });
                    }
                }
            });


        });

        $('.servicehousenumber').blur(function() {
            let id = $(".serviceestateid").find("option:selected").attr('data-id');
            if (id == "0") {
                $('.servicehousenumber').val("");
                alert("Please select Estate");
                return;
            }
            $.ajax({
                method: 'GET',
                url: "{{ route('getmeter') }}",
                data: {
                    estateid: id,
                    housenumber: $(this).val()
                },
                success: function(response) {
                    if (response.status == "ok") {
                        $('.serviceemail').val(response.email);
                        $('.servicephone').val(response.phone);
                        $('.servicemeternumber').val(response.meternumber);
                        $('.firstname').val(response.firstName);
                        $('#servicechargeform .manager_id').val(response.manager_id);
                        
                        toastr.success("Resident found", {
                            timeOut: 5000
                        });
                    } else {
                        toastr.info("Resident not found", {
                            timeOut: 5000
                        });
                    }
                }
            });


        });

        $(document).on("click", "#qPay", function() {
            $('#loginform').addClass('d-none');
            $('#selectoption').removeClass('d-none');
            $("#selectoption select").val("0").change();
            $("#payselect select").val("0").change();
        });

        $(document).on("click", "#dashboard", function() {
            $('#loginform').removeClass('d-none');
            $('#selectoption').addClass('d-none');
            $('#buyunitform').addClass('d-none');
            $('#servicechargeform').addClass('d-none');

        });


        $('#payselect').change(function() {
            let pmethod = $(this).find("option:selected").attr('value');
            if (pmethod == 1) {
                $('#buyunitform').removeClass('d-none');
                $('#servicechargeform').addClass('d-none');
            } else if (pmethod == 2) {
                $('#buyunitform').addClass('d-none');
                $('#servicechargeform').removeClass('d-none');
                $("#servicechargeform select").val("0").change();
            } else {
                $('#buyunitform').addClass('d-none');
                $('#servicechargeform').addClass('d-none');
            }
        });


        $('#estatesc').change(function() {
            let amount = parseInt($(this).find("option:selected").attr('value'));
            let id = $(this).find("option:selected").attr('data-id');
            $('input[name=estateid]').val(id);
            if (parseInt($('#nummonth').val()) > 0) {
                let serviceamount = parseInt($('#nummonth').val()) * amount;
                $('input[name=scamount]').val(serviceamount);
                serviceamount = (serviceamount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                $('#totalamt').html('NGN ' + serviceamount);
            }
        });
        $('#nummonth').on('input', function() {
            var months = parseInt($(this).val());
            let amount = parseInt($('#estatesc').find("option:selected").attr('value'));
            if (months > 0) {
                let serviceamount = months * amount;
                $('input[name=scamount]').val(serviceamount);
                serviceamount = (serviceamount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                $('#totalamt').html('NGN ' + serviceamount);
            }

        });
    });
</script>
