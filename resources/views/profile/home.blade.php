@extends('layouts.profile')

@section('content')
    <div class="wrapper">
        <div class="container-fluid">
            <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2">
                @if(env('SHOWS', false) && Auth::user()->hasShows())
                    <div class="row card-container">
                        @foreach(Auth::user()->getShows() as $show)
                            <div class="col-xs-12 col-md-6">
                                @component('components.show', ['show' => $show, 'style' => 'style="height: 100%"'])
                                    @slot('body')
                                        @php($time = strtotime($show->date))
                                        <p style="margin: 0"><strong>Date: </strong>{{ date('d-m-Y', $time) }} at {{ date('H:m', $time) }}
                                        <br><strong>Seat: </strong>{{ $show->seat }}
                                        <br><strong>Voucher: </strong>{{ $show->voucher }}</p>
                                    @endslot
                                @endcomponent
                            </div>
                        @endforeach
                    </div>
                @else
                    @component('components.panel', ['title' => 'No Shows'])
                        <p>You have no tickets for shows.</p>
                    @endcomponent
                @endif
            </div>
        </div>
    </div>
@endsection
