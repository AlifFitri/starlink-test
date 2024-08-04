@php
$urlPrefix = $this->hubURLPrefix;
 // Convert to the desired format
$initialMarkers = array_map(function ($grid) {
    return [
        'id' => $grid['id'],
        'position' => [
            'lat' => (float) $grid['latitude'],
            'lng' => (float) $grid['longitude'],
        ],
        'name' => $grid['name'],
        'usage' => $grid['usage'].'TB',
        'draggable' => false, // Set draggable based on your logic
    ];
}, $this->hubGrids);
@endphp

<style>
        .text-center {
            text-align: center;
        }
        #map {
            width: '100%';
            height: 400px;
            z-index: 1;
        }
    </style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<x-filament-panels::page>

    <!-- <h1 class='text-center'>Laravel Leaflet Maps</h1> -->
    <div id='map' class='relative p-6 bg-white shadow-sm fi-wi-stats-overview-stat rounded-xl ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10'></div>

</x-filament-panels::page>

    <script>
        let map, markers = [];

        /* --------------------------- Initialize Markers --------------------------- */
        function initMarkers() {
            const initialMarkers = <?php echo json_encode($initialMarkers); ?>;

            for (let index = 0; index < initialMarkers.length; index++) {

                const data = initialMarkers[index];
                const marker = generateMarker(data, index);
                marker.bindTooltip(`<a href="<?php echo $urlPrefix; ?>/${data.id}/edit"><b>${data.name}</b></a><br>${data.usage}`, {
                                    permanent: true,
                                    direction: 'right',
                                    interactive: true,
                                    opacity: 0.8
                                }).openTooltip();
                marker.addTo(map);
                map.panTo(data.position);
                markers.push(marker)
            }
        }

        function generateMarker(data, index) {
            return L.marker(data.position, {
                    draggable: data.draggable
                })
                .on('click', (event) => markerClicked(event, index))
                .on('dragend', (event) => markerDragEnd(event, index));
        }

        /* ------------------------- Handle Map Click Event ------------------------- */
        function mapClicked($event) {
            console.log(map);
            console.log($event.latlng.lat, $event.latlng.lng);
        }

        /* ------------------------ Handle Marker Click Event ----------------------- */
        function markerClicked($event, index) {
            const initialMarkers = <?php echo json_encode($initialMarkers); ?>;
            const data = initialMarkers[index];
            window.location.href = '<?php echo $urlPrefix; ?>/'+data.id+'/edit';
        }

        /* ----------------------- Handle Marker DragEnd Event ---------------------- */
        function markerDragEnd($event, index) {
            console.log(map);
            console.log($event.target.getLatLng());
        }

        /* ----------------------------- Initialize Map ----------------------------- */
        function initMap() {
            map = L.map('map', {
                center: {
                    lat: 28.626137,
                    lng: 79.821603,
                },
                zoom: 15
            });

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
            }).addTo(map);

            map.on('click', mapClicked);
            initMarkers();

            var group = new L.featureGroup(markers);
            map.fitBounds(group.getBounds());
        }
        initMap();
    </script>
