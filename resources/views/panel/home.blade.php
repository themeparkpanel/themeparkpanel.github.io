@extends('layouts.admin')

@section('page', 'Dashboard')

@section('content')
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
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-green-gradient">
                        <div class="inner">
                            <h3>{{ $users }}</h3>
                            <p>User{{ $users != 1 ? 's' : '' }}</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-green-gradient">
                        <div class="inner">
                            <h3>{{ $regions }}</h3>
                            <p>Region{{ $regions != 1 ? 's' : '' }}</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-list-ul"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-green-gradient">
                        <div class="inner">
                            <h3>{{ $attractions }}</h3>
                            <p>Attraction{{ $attractions != 1 ? 's' : '' }}</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-train"></i>
                        </div>
                    </div>
                </div>

                @if(env('SHOWS', false))
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-green-gradient">
                            <div class="inner">
                                <h3>{{ $shows }}</h3>
                                <p>Show{{ $shows != 1 ? 's' : '' }}</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-theater-masks"></i>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
@endsection
