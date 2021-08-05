@extends('layouts.main')

@section('content')
    <div class="wrapper">
        <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2">
            <div class="col-xs-12" style="margin-bottom: 15px">
                <a class="status-card" style="background-image: url({{ $attraction->cover }})">
                    <div class="card-body">
                        <h2 class="card-title">{{ \App\Color\MinecraftColor::stripColor($attraction->name) }}</h2>
                        <label id="status-%STATUS_ID%" class="badge" style="background-color: {{ $attraction->status->color }}">{{ $attraction->status->name }}</label>
                    </div>
                </a>
            </div>

            <div class="container-fluid">
                @component('components.panel', ['title' => 'Ridecount Statistics'])
                    <div class="col-lg-6 col-xs-12 col-md-6 col-sm-12">
                        <p>Personal: {{ $personal }}</p>
                        <p>Total: {{ $total }}</p>
                    </div>
                    <div class="col-lg-6 col-xs-12 col-md-6 col-sm-12">
                        @if(!empty($top10))
                            @php($i = 1)
                            @foreach($top10 as $row)
                                @php($row->uuid = str_replace('-', '', $row->uuid))
                                @php($username = \App\Cache\Cache::getUsername($row->uuid))
                                @if($username !== $row->uuid)
                                    <p><b>{{ $row->num }}#</b> {{ $username }}<b>:</b> {{ $row->count }}</p>
                                @endif
                            @endforeach
                        @else
                            <p>No top 10 available for this attraction</p>
                        @endif
                    </div>
                @endcomponent
            </div>
        </div>
    </div>
@endsection
