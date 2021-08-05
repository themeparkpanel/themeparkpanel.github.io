@extends('layouts.main')

@section('content')
    <div class="wrapper">
        <div class="col-lg-4 col-lg-offset-2 col-md-4 col-md-offset-2">
            @component('components.panel', ['title' => 'Book Show'])
                <div class="container-fluid">
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

                    <form action="{{ route('makeOrder') }}" method="post" class="col-xs-12">
                        @csrf
                        <input name="id" value="{{ $show->id }}" style="display: none">

                        <div class="custom-select" style="width: 100%">
                            <select name="date">
                                @if(!empty($dates))
                                    <option class="disabled" selected>Select Date:</option>
                                    @foreach($dates as $row)
                                        @php($time = strtotime($row['date']))
                                        <option value="{{ $row['date'] }}" free_seats="{{ $row['free_seats'] }}">{{ date('d-m-Y', $time) }} at {{ date('H:i', $time) }}</option>
                                    @endforeach
                                @else
                                    <option class="disabled" selected>No dates to book</option>
                                @endif
                            </select>
                        </div>
                        <br>
                        <button type="submit" name="submit" class="btn-custom"  style="width: 100%">Book Show</button>
                    </form>
                </div>
            @endcomponent
        </div>
        <div class="col-lg-4 col-md-4">
            @component('components.show', ['show' => $show, 'style' => ''])
                <strong>Price: €</strong>{{ $show->price }}
            @endcomponent
        </div>
    </div>
@endsection
