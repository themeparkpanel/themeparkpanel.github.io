@if(!empty(env('APP_LOGO', '')))
    <div class="col-xs-12">
        <img src="{{ env('APP_LOGO') }}" style="max-width: 80%; max-height: 50px; height: auto; width: auto; filter: brightness(0)">
    </div>
@else
    <h2 class="text-center">{{ env('APP_NAME', 'ThemePark') }}</h2>
@endif
