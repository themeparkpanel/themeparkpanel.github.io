@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('page', 'Show Date Manager')

@section('content')
            <div class="col-xs-12 col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title" style="margin-top: 8px">Add Show Date</h3>
                        <small style="float: right"><a class="btn btn-primary" href="{{ route('panel.shows') }}">Back</a></small>
                    </div>
                    <div class="box-body">
                        @if(session('error'))
                        <div class="alert alert-success" role="alert">
                            {{ session('error') }}
                            <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        </div>

                        @endif
                        <form method="POST" action="{{ route('panel.shows.create') }}" class="col-xs-10 col-xs-offset-1">
                            @csrf

                            <div class="form-group @error('show_id') has-error @enderror">
                                <label for="show_id" class="text-md-right">{{ __('Show ID:') }}</label>

                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-tag"></i></span>
                                    <input id="show_id" type="text" class="form-control" placeholder="Show ID" name="show_id" required autocomplete="off" autofocus>
                                </div>
                                @error('show_id')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group @error('date') has-error @enderror">
                                <label for="date" class="text-md-right"><strong>Date:</strong></label>

                                <div class="input-group date" id="picker">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-calendar"></i>
                                    </span>
                                    <input placeholder="Date" type="text" name="date" class="form-control">
                                </div>
                                @error('date')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-block btn-primary">{{ __('Add Show Date') }}</button>
                        </form>
                    </div>
                </div>
            </div>
@endsection

@section('javascript')
<script src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<script>
$(function () {
    $('#picker').datetimepicker({
        format: "DD-MM-YYYY HH:mm",
        minDate: moment()
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#show_id").autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: '{{ route('panel.shows.search') }}',
                type:'POST',
                dataType: "json",
                data: {
                    searchText: request.term
                },
                success: function (data) {
                    response($.map(data, function (item) {
                        return {
                            label: '#'+item.id+' Title: '+item.title,
                            value: item.id
                        };
                    }));
                }
            });
        },
        minLength: 3,
        open: function() {
            $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
        },
        close: function() {
            $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
        }
    });
});
</script>
@endsection
