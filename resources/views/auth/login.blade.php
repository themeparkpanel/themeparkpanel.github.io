@extends('layouts.default')

@section('body')
<div class="page">
    <div class="form">
        <form method="post" action="{{ route('login') }}">
            @csrf
            @component('components.title')
            @endcomponent
            @if($errors->any())

                <div class="alert alert-danger" role="alert">
                    {{ __('Invalid Username or Password') }}
                    <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
                </div>

            @endif
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input id="uuid" type="text" class="form-control" name="uuid" value="{{ old('username') }}" placeholder="Username" required autocomplete="username" autofocus>
            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input id="password" type="password" class="form-control" name="password" placeholder="Password" required autocomplete="current-password">
            </div>

            <button class="btn btn-custom" style="width: 100%">{{ __('Login') }}</button>
            <p>No account yet, <a href="{{ route('register') }}">{{ __('Register one') }} </a>or,
            <br>Did you <a href="{{ route('password.request') }}">{{ __('forget your password') }}</a>?</p>
        </form>
    </div>
</div>
@endsection
