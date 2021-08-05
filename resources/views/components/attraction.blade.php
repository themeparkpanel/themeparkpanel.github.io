<div id="attraction-{{ $attraction->id }}" class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
    <a class="status-card" href="{{ route('ridecount', ['attraction_id' => $attraction->id]) }}" style="background-image: url({{ $attraction->cover }})">
        <div class="card-body">
            <h2 class="card-title">{{ \App\Color\MinecraftColor::stripColor($attraction->name) }}</h2>
            <label id="status-%STATUS_ID%" class="badge" style="background-color: {{ $attraction->status->color }}">{{ $attraction->status->name }}</label>
        </div>
    </a>
</div>
