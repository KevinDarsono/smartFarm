@extends('layouts.farmer.detail-base', ['land' => $land])

@section('meta_title', 'Land ' . $land->name)
@section('page_title', 'Land ' . $land->name)
@section('page_title_icon')
    <i class="metismenu-icon bi bi-columns-gap"></i>
@endsection
@breadcrumbs([
    'Lahan' => route('lands.index'),
    $land->name,
])
@section('css')
    <style>
        #map {
            height: 400px;
            width: 100%;
        }

        #description {
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
        }

        #infowindow-content .title {
            font-weight: bold;
        }

        #infowindow-content {
            display: none;
        }

        #map #infowindow-content {
            display: inline;
        }

        .pac-card {
            background-color: #fff;
            border: 0;
            border-radius: 2px;
            box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
            margin: 10px;
            padding: 0 0.5em;
            font: 400 18px Roboto, Arial, sans-serif;
            overflow: hidden;
            font-family: Roboto;
            padding: 0;
        }

        #pac-container {
            padding-bottom: 12px;
            margin-right: 12px;
        }

        .pac-controls {
            display: inline-block;
            padding: 5px 11px;
        }

        .pac-controls label {
            font-family: Roboto;
            font-size: 13px;
            font-weight: 300;
        }

        #pac-input {
            background-color: #fff;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 400px;
            margin-top: 10px;
        }

        #pac-input:focus {
            border-color: #4d90fe;
        }

        #title {
            color: #fff;
            background-color: #4d90fe;
            font-size: 25px;
            font-weight: 500;
            padding: 6px 12px;
        }

        #target {
            width: 345px;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <div id="map"></div><br>
                    <input type="hidden" name="polygon" value="" id="vertices" />
                    <input type="hidden" name="area" value="" id="area" />
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12 ">
                            <img src="{{ asset($land->image) }}" alt="{{ $land->name }}" class="img-thumbnail">
                        </div>
                    </div>

                    <h5>{{ $land->name }} </h5><div class="mb-2 mr-2 badge badge-info">{{ $land->crop_status }}</div>
                    <p class="card-text">
                        <strong>Deskripsi:</strong>
                        <br>
                        {{ $land->description }}
                        <br>
                        <br>

                        <strong>Usia Tanaman</strong>
                        <br>
                        {{ $land->crop_age }} hari
                    </p>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('js')
    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key={{ env('API_KEY_GOOGLE') }}&libraries=geometry"></script>
    <script>
        // split coordinate data by comma from $land->polygon to polygonCoords
        var polygonCoords = []
        var listcoords = "{{ $land->polygon }}".split(',');
        console.log(listcoords);
        for (var i = 0; i < listcoords.length - 1; i++) {
            var latlng = listcoords[i].split(' ')
            polygonCoords.push({
                lat: parseFloat(latlng[0]),
                lng: parseFloat(latlng[1])
            })
        }

        var bounds = new google.maps.LatLngBounds();
        for (var i = 0; i < polygonCoords.length; i++) {
            bounds.extend(polygonCoords[i]);
        }
        myLatlng = bounds.getCenter();

        var map = new google.maps.Map(document.getElementById("map"), {
            zoom: 13,
            center: {
                lat: parseFloat(myLatlng.lat()),
                lng: parseFloat(myLatlng.lng())
            },
            mapTypeId: "hybrid",
        });
        map.fitBounds(bounds);

        var polygonDrawing = new google.maps.Polygon({
            paths: polygonCoords,
        });
        polygonDrawing.setMap(map);
    </script>
@endsection
