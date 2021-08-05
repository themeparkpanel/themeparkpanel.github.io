@extends('layouts.default')

@section('body')
<div class="page">
    <div class="form">
        @component('components.title')
        @endcomponent
        @if (session('resent'))

        <div class="alert alert-success" role="alert">
            {{ __('Email has been resend.') }}
            <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
        </div>

        @endif
        <p>{{ __('Before proceeding, please check your email for a verification link. If you did not receive an email press the button bellow to resend the email.') }}</p>
        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-custom" style="width: 100%">{{ __('Resend Email') }}</button>
        </form>
    </div>
</div>
@endsection
