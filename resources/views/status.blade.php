@extends('layouts.main')

@section('content')
    <div class="wrapper">
        <div class="container-fluid">
            @php($data = \App\Status::loadData())
            @if(!empty($data))
                @foreach($data as $region)
                    @component('components.region', ['region' => $region])
                    @endcomponent
                @endforeach
            @else
                <div class="col-xs-12 col-lg-4 col-lg-offset-4 col-md-8 col-md-offset-2">
                    @component('components.panel', ['title' => 'No Data'])
                        <p>No Regions with attractions found</p>
                    @endcomponent
                </div>
            @endif
        </div>
    </div>
@endsection
