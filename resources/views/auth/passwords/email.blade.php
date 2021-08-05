@extends('layouts.default')

@section('body')
<div class="page">
    <div class="form">
        <form method="post" action="{{ route('password.email') }}">
            @csrf
            @component('components.title')
            @endcomponent
            @if(session('status'))

            <div class="alert alert-success" role="alert">
                {{ __('Email has been send.') }}
                <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>

            @endif
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email"  required autocomplete="email" autofocus>
            </div>

            <button class="btn btn-custom" style="width: 100%">{{ __('Reset Password') }}</button>
        </form>
    </div>
</div>
@endsection
