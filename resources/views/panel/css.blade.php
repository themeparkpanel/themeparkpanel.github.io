@extends('layouts.admin')

@section('page', 'CSS')

@section('content')
    <div class="container-fluid">
        <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-xs-12">
            <div class="box box-success">
                <div class="box-header">
                    <h4>Edit CSS</h4>
                </div>
                <div class="box-body">
                    <form method="post" action="{{ route('panel.css') }}">
                        @csrf

                        @foreach($styles as $key => $value)
                            <div class="form-group @error($key) has-error @enderror">
                                <label for="email" class="text-md-right">{{ __(ucfirst($key).':') }}</label>

                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-tag"></i></span>
                                    <input id="{{ $key }}" type="text" class="form-control" placeholder="{{ $value }}" name="{{ $key }}" value="{{ $value }}" required autocomplete="off" autofocus>
                                </div>
                                @error($key)
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        @endforeach

                        <button type="submit" class="btn btn-primary">Change</button>
                        <a href="{{ route('panel.css.reset') }}" class="btn btn-primary" style="float: right">Reset</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('assets/js/operator.js') }}"></script>
@endsection
