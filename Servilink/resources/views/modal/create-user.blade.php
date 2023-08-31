<!-- Modal -->
<div class="modal fade" id="modal-add-user" role="dialog" data-backdrop="static" data-keyboard="false"
    aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-md" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <div class="col-12">
                    <h4 class="modal-title" id="myModalLabel">Create resident account </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="position: relative; top:-30px"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="row" style="margin: 20px;">
                    <button type="button" id="single" class="btn btn-lg btn-info pull-right" style="float: right">
                        {{ __('Single Registration  ') }}
                    </button>
                    <button type="button" id="buck" class="btn btn-lg btn-info pull-left" style="float: left">
                        {{ __('Upload Template') }}
                    </button>
                </div>

            </div>
            <div class="modal-body">
                <form method="POST" action="" enctype="multipart/form-data" id="create-regular" style="display: none">
                    @csrf
                    <input name="file" value="0" id="file" hidden>
                    <div class="row">
                        <div>
                            <div class="form-group col-md-12">
                                <div>
                                    <input id="fullname" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus
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
                                        value="{{ old('email') }}" required autocomplete="email" autofocus
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
                                        value="{{ old('phone') }}" autocomplete="phone" pattern=".{11,}" required
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

                                <div>
                                    <input id="housenum" type="text"
                                        class="form-control @error('housenum') is-invalid @enderror" name="housenum"
                                        value="{{ old('housenum') }}" autocomplete="housenum" required
                                        placeholder="House Number" autofocus>

                                    @error('housenum')
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
                                <div>
                                    <input id="meterpan" type="number"
                                        class="form-control @error('meterpan') is-invalid @enderror" name="meterpan"
                                        value="{{ old('meterpan') }}" placeholder="Meter Number" autofocus>
                                    @error('meterpan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <div>
                                    <input id="water" type="number"
                                        class="form-control @error('water') is-invalid @enderror" name="water" value=""
                                        placeholder="Flow Meter Number" autofocus>
                                    @error('water')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label class="label-checkbox100" for="checkpaid">
                                    Service Charge Paid?
                                </label>
                                <input class="input-checkbox100" id="checkpaid" type="checkbox" name="paidservicefee">

                            </div>
                              <div class="form-group col-md-12">
                                <label class="label-checkbox100" for="meterchk">
                                    New Meter?
                                </label>
                                <input class="input-checkbox100" id="meterchk" type="checkbox" name="newmeter">

                            </div>
                            <div id="ispaid" style="display: none">
                                <div class="form-group col-md-12">
                                    <label class="label-checkbox100" for="payday">
                                        Payment date
                                    </label>
                                    <input id="payday" class="form-control" type="date" name="paymentdate">
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="label-checkbox100">
                                        Number paid month
                                    </label>
                                    <input id="nummonth" type="number"
                                        class="form-control @error('nummonth') is-invalid @enderror" name="nummonth"
                                        value="1" min="1" placeholder=" Number of months" autocomplete="off">
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-lg btn-info" id="saveresident" type="submit">
                            Submit
                        </button>
                    </div>

                </form>
                <form method="POST" action="{{ route('store.user') }}" enctype="multipart/form-data"
                    id="templateupload" style="display: none; margin-top:10px">
                    @csrf
                    <input name="file" value="1" id="file" hidden>
                    <div>
                        <div class="form-group col-md-12" style="max-width: 500px;">
                            <label class="custom-file-label" for="customFile">Choose Estate Template File</label>
                            <div class="custom-file text-left">
                                <input type="file" name="file" class="custom-file-input" id="customFile"
                                    accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-lg btn-info" id="upload" type="submit">
                            Submit
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div> {{-- Modal Body --}}
</div>
