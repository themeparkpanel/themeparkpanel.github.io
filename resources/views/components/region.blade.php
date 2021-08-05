<div id="region-{{ $region->id }}" class="region">
    <div class="region-title">
        <span>{{ \App\Color\MinecraftColor::stripColor($region->name) }}</span>
    </div>
    <div class="row" style="margin-top: -20px">
        @foreach($region->attractions as $attraction)
            @component('components.attraction', ['attraction' => $attraction])
            @endcomponent
        @endforeach
    </div>
</div>
