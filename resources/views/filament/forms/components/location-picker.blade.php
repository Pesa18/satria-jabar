<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
    class="-z-500"
>
    <div
        x-data="{ state: $wire.$entangle(@js($getStatePath())) }"
        {{ $getExtraAttributeBag() }}
    >
     <input {{ $applyStateBindingModifiers('wire:model') }}="{{ $getStatePath() }}" hidden />

       <div wire:ignore
    x-init="
        let parsedState = null;

        // kalau state string (edit/view), parse dulu
        if (typeof state === 'string' && state) {
            try {
                parsedState = JSON.parse(state);
            } catch(e) {
                parsedState = null;
            }
        }

        // inisialisasi map
        map = L.map($el).setView(
            [parsedState?.lat ?? -6.200000, parsedState?.lng ?? 106.816666],
            parsedState ? 13 : 5
        );

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href=&quot;http://www.openstreetmap.org/copyright&quot;>OpenStreetMap</a>'
        }).addTo(map);

        let marker;

        // kalau ada data lama → pasang marker
        if (parsedState?.lat && parsedState?.lng) {
            marker = L.marker([parsedState.lat, parsedState.lng], {draggable: true}).addTo(map);

            marker.on('dragend', function(e) {
                var latlng = e.target.getLatLng();
                state = JSON.stringify({ lat: latlng.lat, lng: latlng.lng });
            });
        }

        // klik map → pasang marker baru
        map.on('click', function(e) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker(e.latlng, {draggable: true}).addTo(map);

            state = JSON.stringify({ lat: e.latlng.lat, lng: e.latlng.lng });

            marker.on('dragend', function(e) {
                var latlng = e.target.getLatLng();
                state = JSON.stringify({ lat: latlng.lat, lng: latlng.lng });
            });
        });
    "
    style="height: 400px;"
></div>
    </div>
</x-dynamic-component>

@pushOnce('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    /* turunkan semua pane bawaan Leaflet */
    .leaflet-pane,
    .leaflet-top,
    .leaflet-bottom {
        z-index: 0 !important;
    }

    /* naikin dropdown Filament */
    .tippy-box, 
    .fi-dropdown-panel {
        z-index: 9999 !important;
    }
</style>
@endpushOnce

@pushOnce('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

@endpushOnce
