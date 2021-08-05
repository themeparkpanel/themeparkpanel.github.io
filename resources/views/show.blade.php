@extends('layouts.main')

@section('content')
    <div class="wrapper">
        <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2">
            @if(!empty($shows))
                <div class="row card-container">
                    @foreach($shows as $show)
                        @php if(empty($show->id)) continue; @endphp
                        <div class="col-xs-12 col-md-6">
                            @component('components.show', ['show' => $show, 'style' => 'style="height: 100%"'])
                                <strong>Price: €</strong>{{ $show->price }}
                                <span style="float: right">
                                    <a style="text-decoration: none; color: #333;" href="{{ route('order', ['show_id' => $show->id]) }}">
                                        Buy Ticket <i class="glyphicon glyphicon-shopping-cart"></i>
                                    </a>
                                </span>
                            @endcomponent
                        </div>
                    @endforeach
                </div>
            @else
                @component('components.panel', ['title' => 'No Shows'])
                    <p>There are no shows.</p>
                @endcomponent

            @endif
        </div>
    </div>
@endsection
