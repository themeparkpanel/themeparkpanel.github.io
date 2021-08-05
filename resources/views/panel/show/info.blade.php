@extends('layouts.admin')

@section('page', 'Show Manager')

@section('content')
            <div class="col-xs-12 col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ $show->title }}</h3>
                        <small style="float: right"><a class="btn btn-primary" href="{{ url()->previous() }}">Back</a></small>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <p><strong>ID: #</strong>{{ $show->id }}
                                    <br><strong>Title:</strong> {{ $show->title }}
                                    <br><strong>Description:</strong><br>{{ $show->description }}
                                    <br><strong>Price:</strong> €{{ $show->price }}
                                    <br><strong>Vault Price:</strong> {{ $show->vault_price }}
                                    <br><strong>Seats:</strong> {{ $show->seats }}</p>
                            </div>
                            <div class="col-xs-12 col-md-6 text-center" style="padding: 15px">
                                <img src="{{ $show->image }}" alt="Image" style="width: 50%; height: auto; border-radius: 10px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
