@extends('layouts.farmer.detail-base')
@section('meta_title', 'Manage Lahan')
@section('page_title', 'Lahan')
@section('page_title_sub', 'Manage Lahan')
@section('page_title_icon')
    <i class="metismenu-icon bi bi-columns-gap"></i>
@endsection
@breadcrumbs([
    'Lahan' => route('lands.index'),
    $land->name => route('lands.show', $land->id),
    'Quality Detector',
])

@section('css')
    <style type="text/css">
        .thumb-image {
            float: left;
            width: 100px;
            position: relative;
            padding: 5px;
        }
    </style>
@endsection


@section('content')
    <div class="main-card mb-3 card">
        <div class="card-header">
            <h4 class="card-title">Upload Gambar Padi</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {{-- <label for="image" class="">Gambar Padi</label> --}}
                        <input type="file" name="image" id="image" class="form-control-file" multiple="multiple">
                        @error('image')
                            @include('layouts.components.invalid_feedback', [
                                'message' => $message,
                            ])
                        @enderror

                    </div>
                    <div class="form-group">
                        <button id="btnSubmit" class="btn btn-primary">Proses</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div id="image-holder"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-header">
            <h4 class="card-title">Hasil Deteksi</h4>
        </div>
        <div class="card-body">
            <img id="imgResult" src="" alt="" width="100%">
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $("#image").on('change', function() {
                //Get count of selected files
                var countFiles = $(this)[0].files.length;
                var imgPath = $(this)[0].value;
                var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                var image_holder = $("#image-holder");
                image_holder.empty();
                if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
                    if (typeof(FileReader) != "undefined") {
                        //loop for each file selected for uploaded.
                        for (var i = 0; i < countFiles; i++) {
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                $("<img />", {
                                    "src": e.target.result,
                                    "class": "thumb-image"
                                }).appendTo(image_holder);
                            }
                            image_holder.show();
                            reader.readAsDataURL($(this)[0].files[i]);
                        }
                    } else {
                        alert("This browser does not support FileReader.");
                    }
                } else {
                    alert("Pls select only images");
                }
            });

            $('#btnSubmit').click(function(e) {
                //disable button
                $('#btnSubmit').prop('disabled', true);
                // e.preventDefault();
                var formData = new FormData();
                formData.append('image', $('#image')[0].files[0]);
                let url = '{{ env('CROP_QUALITY_DETECTOR_HOST') }}/result/'
                $.ajax({
                    url: `{{ env('CROP_QUALITY_DETECTOR_HOST') . '/image-services' }}`,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#btnSubmit').prop('disabled', false);
                        let newUrl = url + data.data.imageUrl;
                        $('#imgResult').attr('src', newUrl);
                    }
                });
            });
        });
    </script>
@endsection
