<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- ==============================================
              Title and Meta Tags
    =============================================== -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- ==============================================
                         Favicon
   =============================================== -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon-32x32.png') }}" sizes="32x32" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon-16x16.png') }}" sizes="16x16" />

    <!-- ==============================================
                       CSS Files
    =============================================== -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link href="{{ asset('assets/css/AdminLTE.min.css') }}" rel="stylesheet">
    @yield('css')
    <link href="{{ asset('assets/css/skin.css') }}" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition sidebar-mini">

<div class="wrapper">
    <header class="main-header">
        <a class="logo">
            <span class="logo-mini"><b>{{ env('APP_NAME_SHORT', 'TP') }}</b></span>
            <span class="logo-lg"><b>{{ env('APP_NAME', 'ThemePark') }}</b></span>
        </a>

        <nav class="navbar navbar-static-top">
            <a class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ Auth::user()->photo() }}" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{ Auth::user()->username() }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <img src="{{ Auth::user()->photo() }}" alt="User Image">
                                <p>
                                    {{ Auth::user()->username() }}
                                    <small>{{ Auth::user()->email }}</small>
                                </p>
                            </li>

                            <li class="user-footer">
                                <div class="col-xs-6">
                                    <a href="{{ route('home') }}" class="btn btn-primary btn-block">Panel</a>
                                </div>
                                <div class="col-xs-6">
                                    <a href="{{ route('logout') }}" class="btn btn-primary btn-block">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <aside class="main-sidebar">
        <section class="sidebar">
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ Auth::user()->photo() }}" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->username() }}</p>
                </div>
            </div>

            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">NAVIGATION</li>
                <li @if(Request::is('panel/home*')) class="active" @endif><a href="{{ route('panel.home') }}"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>
                <li @if(Request::is('panel/message*')) class="active" @endif><a href="{{ route('panel.message') }}"><i class="fas fa-feather-alt"></i> <span>Message</span></a></li>
                <li @if(Request::is('panel/ums*')) class="active" @endif><a href="{{ route('panel.ums') }}"><i class="fas fa-users"></i> User Manager</a></li>
                @if(env('SHOWS', false))
                    <li class="treeview @if(Request::is('panel/show*')) menu-open active @endif">
                        <a>
                            <i class="fas fa-theater-masks"></i> <span>Shows</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                        </a>
                        <ul class="treeview-menu" style="display: @if(Request::is('panel/show*')) block @else none @endif">
                            <li @if(Request::is('panel/show') || Request::is('panel/show/*')) class="active" @endif><a href="{{ route('panel.show') }}"><i class="fas fa-feather-alt"></i> Manager</a></li>
                            <li @if(Request::is('panel/shows*')) class="active" @endif><a href="{{ route('panel.shows') }}"><i class="fas fa-calendar-alt"></i> Dates</a></li>
                        </ul>
                    </li>
                @endif
                <li class="treeview @if(Request::is('panel/tools*')) menu-open active @endif">
                    <a>
                        <i class="fas fa-wrench"></i> <span>Tools</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu" style="display: @if(Request::is('panel/tools*')) block @else none @endif">
                        <li @if(Request::is('panel/tools/operator*')) class="active" @endif><a href="{{ route('panel.operator') }}"><i class="fas fa-user-cog"></i> Operator</a></li>
                        <li @if(Request::is('panel/tools/css*')) class="active" @endif><a href="{{ route('panel.css') }}"><i class="fas fa-palette"></i> CSS</a></li>
                    </ul>
                </li>
            </ul>
        </section>
    </aside>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>@yield('page')</h1>
            <ol class="breadcrumb">
                <li><a><i class="fas fa-tachometer-alt"></i> Panel</a></li>
                <li class="active">@yield('page')</li>
            </ol>
        </section>

        <section class="content">
            @yield('content')
        </section>
    </div>

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> {{ env('APP_VERSION', '1.0') }}
        </div>
        <span>Copyright &copy; 2019-{{ date('Y') }} <a href="https://www.iobyte.nl/"><img src="{{ asset('assets/img/logo.png') }}" alt="IOByte"></a>. All rights reserved.</span>
    </footer>

    <div class="control-sidebar-bg"></div>
</div>

<!-- ==============================================
                      JS Files
=============================================== -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/adminlte.min.js') }}"></script>
@yield('javascript')
</body>
</html>
