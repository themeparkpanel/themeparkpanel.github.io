@extends('layouts.profile')

@section('css')
    <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-md-4 hidden-xs">
                    @component('components.panel', ['title' => 'Two-Factor Authentication'])
                        @if($TFA)
                            <form method="POST" action="{{ route('2fa.toggle') }}" class="col-xs-10 col-xs-offset-1">
                                @csrf

                                @if(session('success'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('success') }}
                                        <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    </div>

                                @endif
                                <div class="form-group @error('two_factor') has-error @enderror">
                                    <label for="two_factor" class="text-md-right">{{ __('2FA Code:') }}</label>

                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input id="two_factor" type="text" maxlength="6" class="form-control" name="two_factor" required autocomplete="off" autofocus>
                                    </div>
                                    @error('two_factor')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-custom" style="width: 100%">{{ __('Disable 2FA') }}</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('2fa.toggle') }}" class="col-xs-10 col-xs-offset-1">
                                @csrf

                                @if(session('success'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('success') }}
                                        <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    </div>

                                @endif
                                <div class="text-center">
                                    <img src="{{ $QRCode }}" style="max-width: 250px; max-height: 250px; width: 100%; height: auto">
                                </div>
                                <div class="form-group @error('two_factor') has-error @enderror">
                                    <label for="two_factor" class="text-md-right">{{ __('2FA Code:') }}</label>

                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input id="two_factor" type="text" maxlength="6" class="form-control" name="two_factor" required autocomplete="off" autofocus>
                                    </div>
                                    @error('two_factor')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-custom" style="width: 100%">{{ __('Enable 2FA') }}</button>
                            </form>
                        @endif
                    @endcomponent
                </div>
                <div class="col-xs-12 col-md-8">
                    @component('components.panel', ['title' => 'Sessions'])

                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th class="ip">IP</th>
                                <th class="hidden-xs hidden-sm hidden-md">Country</th>
                                <th class="hidden-xs hidden-sm hidden-md">Browser</th>
                                <th class="hidden-xs">Last Activity</th>
                                <th style="width: 50px" class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="ip">
                                    <code><i class="fa fa-key"></i> {{ preg_replace('/([0-9a-zA-Z])/', '•', Request::ip()) }}</code>
                                    <code class="hidden"><i class="fa fa-eye-slash"></i> {{ Request::ip() }}</code>
                                </td>
                                <td class="hidden-xs hidden-sm hidden-md">{{ geoip(Request::ip())['country'] }}</td>
                                <td class="hidden-xs hidden-sm hidden-md">{{ $agent->browser() }}</td>
                                <td class="hidden-xs">Current Session</td>
                                <td></td>
                            </tr>
                            @foreach($sessions as $session)
                                @php($agent->setUserAgent($session->user_agent))
                                <tr>
                                    <td>
                                        <code><i class="fa fa-key"></i> {{ preg_replace('/([0-9a-zA-Z])/', '•', $session->ip_address) }}</code>
                                        <code class="hidden"><i class="fa fa-eye-slash"></i> {{ $session->ip_address }}</code>
                                    </td>
                                    <td class="hidden-xs hidden-sm hidden-md">{{ geoip($session->ip_address)['country'] }}</td>
                                    <td class="hidden-xs hidden-sm hidden-md">{{ $agent->browser() }}</td>
                                    <td class="hidden-xs">{{ date('H:i:s d-m-Y', $session->last_activity) }}</td>
                                    <td><a href="{{ route('session.delete', ['id' => $session->id]) }}" class="btn btn-custom"><span class="glyphicon glyphicon-trash"></span></a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <nav style="float: right">
                            <ul class="pagination">
                                <li @if($page == 1) class="disabled" @endif>
                                    <a @if($page != 1) href="{{ route('security', ['page' => ($page - 1)]) }}" @endif aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
                                </li>
                                @for($i = 1; $i <= $pages; $i++)
                                    <li @if($i == $page) class="active" @endif>
                                        <a @if($i != $page)href="{{ route('security', ['page' => $i]) }}" @endif><span>{{ $i }}</span></a>
                                    </li>
                                @endfor
                                <li @if($page == $pages) class="disabled" @endif>
                                    <a @if($page != $pages) href="{{ route('security', ['page' => ($page + 1)]) }}" @endif aria-label="Next"><span aria-hidden="true">»</span></a>
                                </li>
                            </ul>
                        </nav>
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
<script src="{{ asset('assets/js/credential.js') }}"></script>
@endsection
