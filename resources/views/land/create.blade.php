@extends('layouts.farmer.base')

@section('meta_title', 'Tambah Lahan')
@section('page_title', 'Tambah Lahan')
@section('page_title_icon')
    <i class="metismenu-icon bi bi-columns-gap"></i>
@endsection

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
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <form action="{{ route('lands.store') }}" method="post" id="form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image" class="">Gambar</label>
                                    <input type="file" name="image" id="image" class="form-control-file">
                                    @error('image')
                                        @include('layouts.components.invalid_feedback', [
                                            'message' => $message,
                                        ])
                                    @enderror
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nama</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control  @error('name') is-invalid @enderror">
                                    @error('name')
                                        @include('layouts.components.invalid_feedback', [
                                            'message' => $message,
                                        ])
                                    @enderror
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="crop_planted_at">Tanggal Tanam</label>
                                    <input type='date' name="crop_planted_at" placeholder="Tanggal Tanam"
                                        class="form-control @error('crop_planted_at') is-invalid @enderror"
                                        id='crop_planted_at'>
                                    @error('crop_planted_at')
                                        @include('layouts.components.invalid_feedback', [
                                            'message' => $message,
                                        ])
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="crop_status">Status</label>
                                    <select class="form-control select2" name="crop_status" id="crop_status">
                                        <option value="belum panen">Belum Panen</option>
                                        <option value="sudah panen">Sudah Panen</option>
                                    </select>
                                    @error('status')
                                        @include('layouts.components.invalid_feedback', [
                                            'message' => $message,
                                        ])
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">Deskripsi</label>
                                    <textarea type="text" name="description" id="description"
                                        class="form-control  @error('description') is-invalid @enderror"></textarea>
                                    @error('description')
                                        @include('layouts.components.invalid_feedback', [
                                            'message' => $message,
                                        ])
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <div id="map"></div><br>
                                    <input id="pac-input" class="controls form-control" type="text"
                                        placeholder="Search" />
                                    <input type="hidden" name="polygon" value="" id="vertices" />
                                    <input type="hidden" name="area" value="" id="area" />
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                {{-- <a href="{{ route('users.index') }}" class="btn btn-danger mr-5">Cancel</a> --}}
                                <input type="submit" value="Add" class="btn btn-success">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key={{ env('API_KEY_GOOGLE') }}&libraries=places,drawing,geometry">
    </script>
    <script>
        var map; // Global declaration of the map
        var iw = new google.maps.InfoWindow(); // Global declaration of the infowindow
        var myPoligons = null;
        var drawingManager;
        var area = 0;

        function initialize() {
            var myOptions = {
                zoom: 13,
                center: {
                    lat: -6.4084094,
                    lng: 108.279263
                },
                mapTypeId: google.maps.MapTypeId.HYBRID
            }
            map = new google.maps.Map(document.getElementById("map"), myOptions);
            drawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: google.maps.drawing.OverlayType.POLYGON,
                drawingControl: true,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_RIGHT,
                    drawingModes: [google.maps.drawing.OverlayType.POLYGON]
                },
                polygonOptions: {
                    editable: true
                }
            });
            drawingManager.setMap(map);

            google.maps.event.addListener(drawingManager, "overlaycomplete", function(event) {
                event.overlay.setMap(null);

                myPoligons = (new google.maps.Polygon({
                    path: event.overlay.getPath().getArray(),
                    editable: true
                }))
                myPoligons.setMap(map);
                processOnChange();
                update();
            });
            if (myPoligons != null) {
                update();
            }

            function update() {
                google.maps.event.addListener(myPoligons.getPath(), 'insert_at', processOnChange);
                google.maps.event.addListener(myPoligons.getPath(), 'set_at', processOnChange);
            }

            function processOnChange() {
                console.log("modified");
                var vertices = myPoligons.getPath();
                var contentString = "";
                var area = google.maps.geometry.spherical.computeArea(vertices);
                var coords = "";
                for (var i = 0; i < vertices.getLength(); i++) {
                    var xy = vertices.getAt(i);
                    coords += xy.lat() + " " + xy.lng() + ",";
                }
                document.getElementById("vertices").value = coords;
                document.getElementById("area").value = area;
            }

            /* ------------------------ SEARCH BOX ------------------------ */
            // Create the search box and link it to the UI element.
            var input = document.getElementById("pac-input");
            var searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
            // Bias the SearchBox results towards current map's viewport.
            map.addListener("bounds_changed", function() {
                searchBox.setBounds(map.getBounds());
            });
            var markers = [];
            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            searchBox.addListener("places_changed", function() {
                var places = searchBox.getPlaces();
                if (places.length == 0) {
                    return;
                }
                // Clear out the old markers.
                markers.forEach(function(marker) {
                    marker.setMap(null);
                });
                markers = [];
                // For each place, get the icon, name and location.
                var bounds = new google.maps.LatLngBounds();
                places.forEach(function(place) {
                    if (!place.geometry || !place.geometry.location) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    var icon = {
                        url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(25, 25),
                    };
                    // Create a marker for each place.
                    markers.push(new google.maps.Marker({
                        map: map,
                        icon: icon,
                        title: place.name,
                        position: place.geometry.location,
                    }));
                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
            });
        }

        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
@endsection
