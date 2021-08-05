@extends('layouts.admin')

@section('page', 'User Manager')

@section('content')
            <div class="col-lg-8 col-lg-offset-2">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title" style="margin-top: 8px">Users</h3>
                    </div>
                    <div class="box-body">
                        @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                            <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        </div>

                        @elseif(session('error'))
                        <div class="alert alert-success" role="alert">
                            {{ session('error') }}
                            <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        </div>

                        @endif
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th style="width: 30px"></th>
                                <th>UUID</th>
                                <th class="text-center">Role</th>
                                <th class="text-center">Verified</th>
                                <th class="hidden-xs hidden-sm hidden-md text-center">Last Active</th>
                                <th class="text-center" style="width: 155px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td style="width: 30px"><img src="{{ $user->photo() }}" style="width: 25px; height: 25px; border-radius: 3px"></td>
                                <td>{{ $user->fixedUUID() }}</td>
                                <td class="text-center"><span class="text-center bg-green-gradient" style="padding: 8px 15px 8px 15px; border-radius: 3px; color: #fff">{{ ($user->is_root ? 'Root' : ($user->is_admin ? 'Admin' : 'Normal')) }}</span></td>
                                <td class="text-center">{!! $user->email_verified_at != null ? '<i class="fas fa-check yes"></i>' : '<i class="fas fa-times no"></i>' !!}</td>
                                <td class="hidden-xs hidden-sm hidden-md text-center">@if(!empty($user->last_active)) {{ date('H:i:s d-m-Y', $user->id === Auth::id() ? time() : strtotime($user->last_active)) }} @else {{ __('No Activity') }} @endif</td>
                                <td style="width: 155px"><a class="btn btn-primary" href="{{ route('panel.ums.info', ['id' => $user->id]) }}"><i class="glyphicon glyphicon-info-sign"></i></a> <a class="btn btn-primary" style="margin-left: 2px" href="{{ route('panel.ums.edit', ['id' => $user->id]) }}"><i class="glyphicon glyphicon-pencil"></i></a> @if(Auth::user()->is_root) <a class="btn btn-primary" style="margin-left: 2px" href="{{ route('panel.ums.delete', ['id' => $user->id]) }}"><i class="glyphicon glyphicon-trash"></i></a> @endif </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <nav style="float: right">
                            <ul class="pagination">
                                <li @if($page == 1) class="disabled" @endif>
                                    <a @if($page != 1) href="{{ route('panel.ums', ['page' => ($page - 1)]) }}" @endif aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
                                </li>
                                @for($i = 1; $i <= $pages; $i++)
                                <li @if($i == $page) class="active" @endif>
                                    <a @if($i != $page)href="{{ route('panel.ums', ['page' => $i]) }}" @endif><span>{{ $i }}</span></a>
                                </li>
                                @endfor
                                <li @if($page == $pages) class="disabled" @endif>
                                    <a @if($page != $pages) href="{{ route('panel.ums', ['page' => ($page + 1)]) }}" @endif aria-label="Next"><span aria-hidden="true">»</span></a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
@endsection
