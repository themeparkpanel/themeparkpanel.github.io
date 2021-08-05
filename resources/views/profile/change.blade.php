@extends('layouts.profile')

@section('content')
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-md-4 col-md-offset-2">
                    @component('components.panel', ['title' => 'Change Password'])
                        <form method="POST" action="{{ route('change.password') }}" class="col-xs-10 col-xs-offset-1">
                            @csrf

                            @if(session('pass_success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('pass_success') }}
                                    <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                </div>

                            @endif
                            <div class="form-group @error('pass_password') has-error @enderror">
                                <label for="pass_password" class="text-md-right">{{ __('Current Password:') }}</label>

                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input id="pass_password" type="password" class="form-control" placeholder="Current Password" name="password" required autocomplete="off" autofocus>
                                </div>
                                @error('pass_password')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group @error('new_password') has-error @enderror">
                                <label for="new_password" class="text-md-right">{{ __('New Password:') }}</label>

                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input id="new_password" type="password" class="form-control" placeholder="New Password" name="new_password" required autocomplete="off" autofocus>
                                </div>
                                @error('new_password')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group @error('new_confirm_password') has-error @enderror">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input id="new_confirm_password" type="password" class="form-control" placeholder="Confirm New Password" name="new_confirm_password" required autocomplete="off" autofocus>
                                </div>
                                @error('new_confirm_password')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-custom" style="width: 100%">{{ __('Change Password') }}</button>
                        </form>
                    @endcomponent
                </div>

                <div class="col-xs-12 col-md-4">
                    @component('components.panel', ['title' => 'Change Email'])
                        <form method="POST" action="{{ route('change.email') }}" class="col-xs-10 col-xs-offset-1">
                            @csrf

                            @if(session('email_success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('email_success') }}
                                    <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                </div>

                            @endif
                            <div class="form-group @error('email_password') has-error @enderror">
                                <label for="email_password" class="text-md-right">{{ __('Current Password:') }}</label>

                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input id="email_password" type="password" class="form-control" placeholder="Current Password" name="password" required autocomplete="off" autofocus>
                                </div>
                                @error('email_password')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group @error('new_email') has-error @enderror">
                                <label for="new_email" class="text-md-right">{{ __('New Email:') }}</label>

                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                    <input id="new_email" type="email" class="form-control" placeholder="New Email" name="new_email" required autocomplete="off" autofocus>
                                </div>
                                @error('new_email')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group @error('new_confirm_email') has-error @enderror">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                    <input id="new_confirm_email" type="email" class="form-control" placeholder="Confirm New Email" name="new_confirm_email" required autocomplete="off" autofocus>
                                </div>
                                @error('new_confirm_email')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-custom" style="width: 100%">{{ __('Change Email') }}</button>
                        </form>
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        window.onload = () => {
            const passInput = document.getElementById('new_confirm_password');
            passInput.onpaste = (e) => {
                e.preventDefault();
            };

            const emailInput = document.getElementById('new_confirm_email');
            emailInput.onpaste = (e) => {
                e.preventDefault();
            };
        };
    </script>
@endsection
