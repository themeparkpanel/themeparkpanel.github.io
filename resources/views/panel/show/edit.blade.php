@extends('layouts.admin')

@section('page', 'Show Manager')

@section('content')
            <div class="col-xs-12 col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title" style="margin-top: 8px"><strong>Title: </strong>{{ $show->title }}</h3>
                        <small style="float: right"><a class="btn btn-primary" href="{{ route('panel.show') }}">Back</a></small>
                    </div>
                    <div class="box-body">
                        @if(session('error'))
                        <div class="alert alert-success" role="alert">
                            {{ session('error') }}
                            <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        </div>

                        @endif
                            <form method="POST" action="{{ route('panel.show.update') }}" class="col-xs-10 col-xs-offset-1">
                                @csrf
                                <input name="id" value="{{ $show->id }}" style="display: none">

                                <div class="form-group @error('description') has-error @enderror">
                                    <label for="description" class="text-md-right">{{ __('Description:') }}</label>

                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                        <textarea id="description" class="form-control" placeholder="Description" name="description" required autofocus style="height: 150px; resize: none">{{ $show->description }}</textarea>
                                    </div>
                                    @error('description')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group @error('price') has-error @enderror">
                                    <label for="price" class="text-md-right">{{ __('Price:') }}</label>

                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-euro"></i></span>
                                        <input id="price" type="number" step="0.01" class="form-control" placeholder="Price" name="price" value="{{ $show->price }}" required autocomplete="off" autofocus>
                                    </div>
                                    @error('price')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group @error('vault_price') has-error @enderror">
                                    <label for="vault_price" class="text-md-right">{{ __('Vault Price:') }}</label>

                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-euro"></i></span>
                                        <input id="vault_price" type="number" step="0.01" class="form-control" placeholder="Vault Price" name="vault_price" value="{{ $show->vault_price }}" required autocomplete="off" autofocus>
                                    </div>
                                    @error('vault_price')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group @error('image') has-error @enderror">
                                    <label for="image" class="text-md-right">{{ __('Image:') }}</label>

                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                                        <input id="image" type="text" class="form-control" placeholder="Image" name="image" value="{{ $show->image }}"  required autocomplete="off" autofocus>
                                    </div>
                                    @error('image')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-block btn-primary">{{ __('Edit Show') }}</button>
                            </form>
                    </div>
                </div>
            </div>
@endsection
