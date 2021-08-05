<div class="banner">
    <div>
        @if(!empty(env('APP_LOGO', '')))
            <img src="{{ env('APP_LOGO') }}" style="max-width: 80%; max-height: 50px; height: auto; width: auto">
        @else
            <h2 class="text-center" style="color: #fff">{{ env('APP_NAME', 'ThemePark') }}</h2>
        @endif
    </div>
</div>

<nav class="navbar navbar-theme">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapses" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbar-collapses" style="text-align: center">
            <ul class="nav navbar-nav" style="float: none; display: inline-block">
                {{ $slot }}
            </ul>
        </div>
    </div>
</nav>
