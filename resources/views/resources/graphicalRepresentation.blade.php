@extends("layouts.app")
@section('content')

<title>Resource Map</title>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<style>
    #map {
        height: 80vh;
        width: 100%;
    }
    #searchForm {
        width: 50%;
        margin: 10px 0;
        display: flex;
        align-items: center;
        gap: 1em;
    }
    #searchForm button,#locationForm #redirectBtn {
        margin: 10px 0;
        text-align: center;
        background-color: #2d6d8b;
        color: white;
        padding: 5px 7px;
        border-radius: 5px;
        transition: 0.4s ease;
        border: none;
        text-wrap: nowrap;
    }
    #searchForm button:hover,#locationForm #redirectBtn:hover {
        letter-spacing: 1px;
        color: #e94d65;
    }
    #searchForm input {
        width: 35%;
        height: 4em;
    }
    #locationForm {
        width: 50%;
        margin: 10px 0;
        display: flex;
        align-items: center;
        gap: 1em;
    }
</style>

<body>
    <div id="searchForm">
        <input type="text" id="placeName" class="input" placeholder="Enter country or city name" />
        <button id="searchBtn">Search</button>
    </div>

    <div id="locationForm">
        <input type="text" id="currentLocation" class="input" placeholder="Enter Current Location" />
        <input type="text" id="destinationLocation" class="input" placeholder="Destination Location" readonly />
        <button id="redirectBtn">Google Maps</button>
    </div>

    <div id="map"></div>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
    var map = L.map('map', {
        attributionControl: false,
        zoomControl: false,
        minZoom: 2,
        maxZoom: 12,
        maxBounds: [[-90, -180], [90, 180]],
        maxBoundsViscosity: 1.0
    }).setView([20, 0], 3);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        noWrap: true
    }).addTo(map);

    var resources = @json($resources);
    var destinationLocation = null;

    resources.forEach(function(resource) {
        if (resource.latitude && resource.longitude) {
            var marker = L.marker([resource.latitude, resource.longitude]).addTo(map)
                .bindPopup(
                    `<b>Name: ${resource.name}</b><br>
                     Email: ${resource.email}<br>
                     Address: ${resource.address}<br>
                     Whatsapp: <a href="${resource.whatsapp_link}" target="_blank">Open</a>`
                );

            marker.on('click', function() {
                document.getElementById('destinationLocation').value = resource.address;
                destinationLocation = resource.address;
            });
        }
    });

    document.getElementById('searchBtn').addEventListener('click', function() {
        var placeName = document.getElementById('placeName').value;

        if (placeName) {
            axios.get(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(placeName)}`)
                .then(function(response) {
                    if (response.data && response.data.length > 0) {
                        var location = response.data[0];
                        var lat = parseFloat(location.lat);
                        var lng = parseFloat(location.lon);

                        map.setView([lat, lng], 12);
                    } else {
                        alert('Location not found. Please enter a valid country or city name.');
                    }
                })
                .catch(function(error) {
                    alert('Error fetching location data.');
                });
        } else {
            alert('Please enter a country or city name.');
        }
    });

    document.getElementById('redirectBtn').addEventListener('click', function() {
        var currentLocation = document.getElementById('currentLocation').value;

        if (currentLocation && destinationLocation) {
            var googleMapsUrl = `https://www.google.com/maps/dir/?api=1&origin=${encodeURIComponent(currentLocation)}&destination=${encodeURIComponent(destinationLocation)}`;
            window.open(googleMapsUrl, '_blank');
        } else {
            alert('Please ensure both current location and destination location are set.');
        }
    });
    </script>

@endsection
