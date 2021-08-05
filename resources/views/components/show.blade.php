<div class="card" {!! $style !!}>
    <img class="card-cover" src="{{ $show->image }}">
    <div class="card-body">
        <h4 class="card-title">{{ $show->title }}</h4>
        <p>{{ $show->description }}</p>

        @if(isset($body))
            {{ $body }}
        @endif
    </div>
    @if(isset($slot) && !empty(str_replace(' ', '', $slot)))
    <p class="card-footer">
        {{ $slot }}
    </p>
    @endif
</div>
