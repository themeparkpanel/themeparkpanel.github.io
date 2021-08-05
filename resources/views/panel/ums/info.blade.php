@extends('layouts.admin')

@section('page', 'Profile')

@section('content')
            <div class="col-xs-12 col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ $user->username() }}</h3>
                        <small style="float: right"><a class="btn btn-primary" href="{{ url()->previous() }}">Back</a></small>
                    </div>
                    <div class="box-body">
                        <p><strong>ID: #</strong>{{ $user->id }}
                        <br><strong>UUID:</strong> {{ $user->fixedUUID() }}
                        <br><strong>Username:</strong> {{ $user->username() }}
                        <br><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Verified:</strong> {!! $user->email_verified_at != null ? '<i class="fas fa-check yes"></i>' : '<i class="fas fa-times no"></i>' !!}</p>
                        <p><strong>Role:</strong> <span class="text-center bg-green-gradient" style="padding: 8px 15px 8px 15px; border-radius: 3px; color: #fff">{{ ($user->is_root ? 'Root' : ($user->is_admin ? 'Admin' : 'Normal')) }}</span></p>
                    </div>
                </div>
            </div>
@endsection
