@extends('admin.layouts.base')

@section('meta_title', 'Manage Sensor ')
@section('page_title', 'Kalibrasi Page')
@section('page_title_icon')
<em class="metismenu-icon bi bi-columns-gap"></em>
@endsection

@section('content')
<div class="col-md-12">

    @if (session("message"))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil ! {!! session("message") !!}</strong>
    </div>
    @endif

</div>
<br>

{{-- get data sensor in range --}}
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">process modus and input {{ $data['sensor']->sensor }} sensor measurement</h2>
        </div>
        <div class="card-body">
            <div class="form-box">
                <form method="post" id="dynamic-form" action="{{ route('admin.sensor.show.range', ['id' => $data['sensor']->id]) }}">
                    @csrf
                    @method("PUT")
                    <!-- Get Data Sensor Section -->
                    <div id="get-data-sensor-section">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="start_date">Start Date:</label>
                                <input class="form-control" class="form-control-date" type="date" name="start_date[]" required><br><br>
                            </div>
                            <div class="col-md-6">
                                <label for="start_time">Start Time:</label>
                                <input class="form-control" type="time" name="start_time[]" required><br><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="end_date">End Date:</label>
                                <input class="form-control" class="form-control-date" type="date" name="end_date[]" required><br><br>
                            </div>
                            <div class="col-md-6">
                                <label for="end_time">End Time:</label>
                                <input class="form-control" type="time" name="end_time[]" required><br><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="alat_ukur">Alat Ukur:</label>
                                <input class="form-control" type="number" name="alat_ukur[]" required><br><br>
                            </div>
                        </div>
                    </div>

                    <!-- Button to Add Additional Get Data Sensor -->
                    <button id="add-data-sensor" type="button" class="btn btn-secondary">Add Data Sensor</button>
                    {{-- reset data table --}}
                    <button id="reset-data" type="button" class="btn btn-danger">Reset Data</button>
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<br>

{{-- import excel for dummy data sensor --}}
@endsection

@push('js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const addButton = document.getElementById("add-data-sensor");
        const getDataSensorSection = document.getElementById("get-data-sensor-section");
        const resetButton = document.getElementById("reset-data");
        const resetButtonTable = document.getElementById("reset-data-table");

        addButton.addEventListener("click", function() {
            const newRow = document.createElement("div");
            newRow.className = "row";
            newRow.innerHTML = `
            <div class="col-md-6">
                <label for="start_date">Start Date:</label>
                <input class="form-control" class="form-control-date" type="date" name="start_date[]" required><br><br>
            </div>
            <div class="col-md-6">
                <label for="start_time">Start Time:</label>
                <input class="form-control" type="time" name="start_time[]" required><br><br>
            </div>
            <div class="col-md-6">
                <label for="end_date">End Date:</label>
                <input class="form-control" class="form-control-date" type="date" name="end_date[]" required><br><br>
            </div>
            <div class="col-md-6">
                <label for="end_time">End Time:</label>
                <input class="form-control" type="time" name="end_time[]" required><br><br>
            </div>
            <div class="col-md-6">
                <label for="alat_ukur">Alat Ukur:</label>
                <input class="form-control" type="number" name="alat_ukur[]" required><br><br>
            </div>
            `;

            getDataSensorSection.appendChild(newRow);
        });

        resetButton.addEventListener("click", function() {
            // Reset Data Sensor Section
            getDataSensorSection.innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <label for="start_date">Start Date:</label>
                    <input class="form-control" class="form-control-date" type="date" name="start_date[]" required><br><br>
                </div>
                <div class="col-md-6">
                    <label for="start_time">Start Time:</label>
                    <input class="form-control" type="time" name="start_time[]" required><br><br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="end_date">End Date:</label>
                    <input class="form-control" class="form-control-date" type="date" name="end_date[]" required><br><br>
                </div>
                <div class="col-md-6">
                    <label for="end_time">End Time:</label>
                    <input class="form-control" type="time" name="end_time[]" required><br><br>
                </div>
                <div class="col-md-6">
                    <label for="alat_ukur">Alat Ukur:</label>
                    <input class="form-control" type="number" name="alat_ukur[]" required><br><br>
                </div>
            </div>
            `;
        });
        resetButtonTable.addEventListener("click", function() {
            // Hapus konten tabel
            const tbody = document.querySelector("tbody");
            while (tbody.firstChild) {
                tbody.removeChild(tbody.firstChild);
            }

            // Tambahkan pesan reset data
            const resetMessage = document.createElement("tr");
            resetMessage.innerHTML = `
            <td colspan="3">Data telah direset.</td>
            `;
            tbody.appendChild(resetMessage);
        });

    });
</script>
@endpush
