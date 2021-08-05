@extends('layouts.default')

@section('body')
<div class="page">
    <div class="form">
        <form method="post" action="{{ route('register') }}">
            @csrf
            @component('components.title')
            @endcomponent
            @if($errors->any())

            <div class="alert alert-danger" role="alert">
                {{ __($errors->first()) }}
                <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>

            @endif
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Username" required autocomplete="username" autofocus>
            </div>

            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email" autofocus>
            </div>

            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input id="password" type="password" class="form-control" name="password" placeholder="Password" required autocomplete="off">
            </div>

            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required autocomplete="off">
            </div>

            <button class="btn btn-custom" style="width: 100%">{{ __('Register') }}</button>
            <p>Already have an account, <a href="{{ route('login') }}">{{ __('Login') }} </a></p>
        </form>
    </div>
</div>
@endsection

@section('javascript')
<script>
    window.onload = () => {
        const passInput = document.getElementById('password_confirmation');
        passInput.onpaste = (e) => {
            e.preventDefault();
        };
    };
</script>
@endsection
