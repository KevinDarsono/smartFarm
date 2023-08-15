@extends('layouts.farmer.detail-base')
@section('meta_title', 'Tambah Lahan')
@section('page_title', 'Tambah Lahan')
@section('page_title_icon')
    <i class="metismenu-icon bi bi-columns-gap"></i>
@endsection
@breadcrumbs([
    'Lahan' => route('lands.index'),
    $land->name => route('lands.show', $land->id),
    'Devices' => route('lands.devices.index', $land->id),
    'Create',
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
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <form action="{{ route('lands.devices.store', $land->id) }}" method="post" id="form"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id">Device ID</label>
                                    <input type="number" name="id" id="id"
                                        class="form-control  @error('id') is-invalid @enderror"
                                        placeholder="Contoh: 934823748923432462">
                                    @error('id')
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
                                        class="form-control  @error('name') is-invalid @enderror"
                                        placeholder="Contoh: Node 1">
                                    @error('name')
                                        @include('layouts.components.invalid_feedback', [
                                            'message' => $message,
                                        ])
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-block text-right card-footer">
                            {{-- <a href="{{ route('users.index') }}" class="btn btn-danger">Cancel</a> --}}
                            <input type="submit" value="Add" class="btn btn-success">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
@endsection
