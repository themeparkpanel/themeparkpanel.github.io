@extends('layouts.admin')

@section('page', 'User Manager')

@section('content')
            <div class="col-xs-12 col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title" style="margin-top: 8px"><strong>Username: </strong>{{ $user->username() }}</h3>
                        <small style="float: right"><a class="btn btn-primary" href="{{ route('panel.ums') }}">Back</a></small>
                    </div>
                    <div class="box-body">
                        @if(session('error'))
                        <div class="alert alert-success" role="alert">
                            {{ session('error') }}
                            <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        </div>

                        @endif
                        <form method="POST" action="{{ route('panel.ums.update') }}" class="col-xs-10 col-xs-offset-1">
                            @csrf
                            <input type="number" name="id" value="{{ $user->id }}" style="display: none">

                            <div class="form-group @error('email') has-error @enderror">
                                <label for="email" class="text-md-right">{{ __('Email:') }}</label>

                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                    <input id="email" type="email" class="form-control" placeholder="Email Address" name="email" value="{{ $user->email }}" required autocomplete="off" autofocus>
                                </div>
                                @error('email')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Verified:</label>
                                <select name="verified" class="form-control" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                    <option value="0" @if(empty($user->email_verified_at)) selected="selected" @endif >Unverified</option>
                                    <option value="1" @if(!empty($user->email_verified_at)) selected="selected" @endif >Verified</option>
                                </select>
                            </div>
                            @if(Auth::user()->is_root)
                            <div class="form-group">
                                <label>Role:</label>
                                <select name="admin" class="form-control" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                    <option value="0" @if(!$user->is_admin && !$user->is_root) selected="selected" @endif >Normal</option>
                                    <option value="1" @if($user->is_admin && !$user->is_root) selected="selected" @endif >Admin</option>
                                    <option value="2" @if(!$user->is_admin && $user->is_root) selected="selected" @endif >Root</option>
                                </select>
                            </div>
                            @endif

                            <button type="submit" class="btn btn-block btn-primary">{{ __('Edit User') }}</button>
                        </form>
                    </div>
                </div>
            </div>
@endsection
