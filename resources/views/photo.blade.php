@extends('layouts.main')

@section('content')
<div class="wrapper">
    <div class="row x">
        @if(!empty($photos))
        @foreach($photos as $photo)
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 y">
            <img class="actionfoto" src="data:image/png;base64,{{ $photo->base64 }}">
        </div>
        @endforeach
        @endif
    </div>
</div>
@endsection
