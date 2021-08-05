@extends('layouts.main')

@section('content')
    <div class="wrapper">
        <div class="container-fluid">
            <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2">
                @if(!empty($message))
                    @component('components.panel')
                        @slot('title')
                            @php($time = strtotime($message->created_at))
                            {{ \App\Cache\Cache::getUsername($message->uuid) }}<span style="float: right">{{ date('d-m-Y', $time) }} at {{ date('H:m', $time) }}</span>
                        @endslot
                        {!! $message->content !!}
                    @endcomponent
                @endif
            </div>
        </div>
    </div>
@endsection
