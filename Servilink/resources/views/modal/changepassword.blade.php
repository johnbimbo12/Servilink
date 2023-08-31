<div class="modal fade" id="changepassword" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Change Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" enctype="multipart/form-data" id="passform">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="password" class="col-form-label">{{ __('Password') }}</label>
                            <div>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="password-confirm" class="col-form-label">{{ __('Confirm Password') }}</label>

                            <div>
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-lg btn-info" id="updatepwd" type="submit">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div> {{-- Modal Body --}}

</div> {{-- End Modal Dialog --}}
</div> {{-- End Modal --}}
