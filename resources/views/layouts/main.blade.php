@extends('layouts.default')

@section('body')
    @component('components.navbar')
        @if(env('HOME_PAGE', false))
            <li @if(Request::is('/') || Request::is('home*')) class="active" @endif><a href="{{ route('home') }}">Home</a></li>
        @endif
        <li @if(Request::is('status*') || Request::is('ridecount*')) class="active" @endif><a href="{{ route('status') }}">Attraction Status</a></li>
        @if(Route::has('photo'))
            <li @if(Request::is('photo*')) class="active" @endif><a href="{{ route('photo') }}">ActionFoto's</a></li>
        @endif
        <li  @if(Request::is('shows*') || Request::is('order*')) class="active" @endif><a href="{{ route('shows') }}">Show</a></li>
        @if(Route::has('store'))
            <li><a href="{{ route('store') }}">Store</a></li>
        @endif
        @if(Route::has('openaudiomc'))
            <li @if(Request::is('openaudiomc*')) class="active" @endif><a href="{{ route('openaudiomc') }}">OpenAudioMC</a></li>
        @endif

        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->username() }}<span class="caret"></span></a><ul class="dropdown-menu">
                <li><a href="{{ route('profile.home') }}">Profile</a></li>
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
