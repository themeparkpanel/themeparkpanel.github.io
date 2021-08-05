@extends('layouts.main')

@section('content')
    <div class="wrapper">
        <div class="container-fluid">
            <div class="col-xs-12 col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2">
                @component('components.panel', ['title' => 'OpenAudioMC'])
                    @if($type === 1)
                        <p>Welcome to the audio client page!
                            <br><br>Unfortunately, this server hasn't linked their OpenAudioMc account to the panel yet, but when they do, this page will re-direct you to your web client so you can open it from here with your personal login token.
                            To get started, login to your Craftmend Account, go to the "API" tab and copy the url labeled "Online Players - V1" and paste it into the .env file. Remember to change <strong>"{your api key}"</strong> for correct installation.</p>
                    @elseif($type=== 2)
                        <p>Hey there {{ Auth::user()->username() }}!
                            <br><br>You aren't online in the server right now and thus can't connect to the audio client. Please login or try again in a few seconds.</p>
                    @else
                        <p>You seem to already have an open session with the audio client. You may dismiss this page since you are already connected or try again in a few seconds if you have closed it recently.</p>
                    @endif
                @endcomponent
            </div>
        </div>
    </div>
@endsection
