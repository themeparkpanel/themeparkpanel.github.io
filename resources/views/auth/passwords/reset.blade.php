@extends('layouts.default')

@section('body')
<div class="page">
    <div class="form">
        <form method="post" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            @component('components.title')
            @endcomponent

            <div class="form-group @error('email') has-error @enderror">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                    <input id="email" type="email" class="form-control" name="email" value="{{ $email ?? old('email') }}" placeholder="Email"  required autocomplete="email" autofocus>
                </div>
                @error('email')
                <span class="help-block" style="font-size: 12px">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group @error('password') has-error @enderror">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input type="password" class="form-control" name="password" placeholder="Password" required autocomplete="new-password">
                </div>
                @error('password')
                <span class="help-block" style="font-size: 12px">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
            </div>

            <button class="btn btn-custom" style="width: 100%">{{ __('Reset Password') }}</button>
        </form>
    </div>
</div>
@endsection
