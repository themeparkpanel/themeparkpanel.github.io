@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/minified/themes/default.min.css') }}"/>
@endsection

@section('page', 'Dashboard')

@section('content')
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-8col-xs-12 col-sm-12">
                        @php($message = \App\Message::orderByDesc('id')->first())
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

                    <div class="box box-success col-lg-12 col-md-12 hidden-xs hidden-sm">
                        <div class="box-header">
                            <h4>Edit Message</h4>
                        </div>
                        <div class="box-body">
                            <form method="post" action="">
                                @csrf

                                @if(session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                    <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                </div>

                                @elseif(session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                    <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                </div>

                                @endif
                                <textarea id="editor" name="message" class="editor" placeholder="Message">{!! !empty($message) ? $message->content : '' !!}</textarea>
                                <button class="btn btn-primary btn-block" type="submit" name="submit" style="margin-top: 5px">Post Message</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
@endsection

@section('javascript')
<script src="{{ asset('assets/minified/sceditor.min.js') }}"></script>
<script>
var textarea = document.getElementById("editor");
sceditor.create(textarea, {
    plugins: 'undo, autosave',
    format: 'bbcode',
    style:  '{{ asset('assets/minified/themes/default.min.css') }}',
    emoticonsRoot: '{{ asset('assets/img').'/' }}',
    locale: 'en',
    width: '100%'
});
</script>
@endsection
