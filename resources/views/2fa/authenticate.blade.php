@extends('layouts.default')

@section('body')
    <div class="page">
        <div class="form">
            <form method="post" action="{{ route('login') }}" action="{{ route('2fa.authenticate') }}">
                @csrf
                @component('components.title')
                @endcomponent

                <div class="form-group @error('two_factor') has-error @enderror">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="two_factor" type="text" class="form-control" name="two_factor" required autocomplete="off" autofocus>
                    </div>
                    @error('two_factor')
                    <span class="help-block" style="font-size: 12px">{{ $message }}</span>
                    @enderror
                </div>

                <button class="btn btn-custom" style="width: 100%">{{ __('Authenticate') }}</button>
                <a class="btn btn-link" href="{{ route('logout') }}">{{ __('Logout') }}</a>
            </form>
        </div>
    </div>
@endsection
