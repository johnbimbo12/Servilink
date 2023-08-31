<!-- Modal -->
<div class="modal fade" id="modal-edit-resident" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-md" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Update Resident Account </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" enctype="multipart/form-data" id="edit-resident">
                    @csrf
                    <input name="user_id" id="data_id" value="" hidden>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <div>
                                <label for="">Full Name</label>
                                <input id="fullnameedit" type="text"
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
                                <label for="">Email Address</label>
                                <input id="emailedit" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
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
                                <label for="">Phone Number</label>
                                <input id="phoneedit" type="text" class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" value="{{ old('phone') }}" autocomplete="phone" pattern=".{11,}"
                                    required title=" Minimum of 11 digits is require for a valid phone number"
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
                                <label for="">House Number</label>
                                <input id="housenumedit" type="text" class="form-control @error('housenum') is-invalid @enderror"
                                    name="housenum" value="{{ old('housenum') }}" autocomplete="housenum"
                                    required 
                                    placeholder="House Number" autofocus>

                                @error('housenum')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div>
                                <label for="">Meter Number</label>
                                <input id="meterpanedit" type="number"
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
                                <label for="">Water Meter Number</label>
                                <input id="waternoedit" type="number"
                                    class="form-control @error('waternumber') is-invalid @enderror" name="waternumber"
                                    value="{{ old('waternoedit') }}" placeholder="Water Meter Number" autofocus>
                                @error('waternumner')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        
                        <div class="form-group col-md-12">
                            <div>
                                <label for="">Enable/Disable Resident </label>
                                <select name="status" class="form-control" id="status" required>
                                    <option value="1">Enable</option>
                                    <option value="0">Disable</option>
                                </select>

                            </div>
                            @error('enabled')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                   </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-lg btn-info" id="generate" type="submit">
                    Submit
                </button>
            </div>
            </form>
        </div>
    </div> {{-- Modal Body --}}

</div> {{-- End Modal Dialog --}}
</div> {{-- End Modal --}}
