@extends('layouts.default')

@section('body')
    @component('components.navbar')
        <li @if(Request::is('profile/home*')) class="active" @endif><a href="{{ route('profile.home') }}">Home</a></li>
        <li @if(Request::is('profile/security*')) class="active" @endif><a href="{{ route('security') }}">Security</a></li>
        <li @if(Request::is('profile/change*')) class="active" @endif><a href="{{ route('change') }}">Change</a></li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->username() }}<span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="{{ route('home') }}">Panel</a></li>
                @if(Auth::user()->is_admin || Auth::user()->is_root)
                    <li><a href="{{ route('panel.home') }}">Admin</a></li>
                    <li role="separator" class="divider"></li>
                @endif
                <li><a href="{{ route('logout') }}">Logout</a></li>
            </ul>
        </li>
    @endcomponent

    @yield('content')
@endsection
