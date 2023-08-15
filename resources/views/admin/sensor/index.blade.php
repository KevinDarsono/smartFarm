@extends('admin.layouts.base')

@section('meta_title', 'Manage Sensor')
@section('page_title', 'Sensor Dashboard')
@section('page_title_icon')
    <em class="metismenu-icon bi bi-columns-gap"></em>
@endsection
@section('content')
<div class="row">
    <div class="col-md-6 col-lg-3">
        <div class="card mb-3 widget-content bg-midnight-bloom">
            <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                    <div class="widget-heading">Total Sensors</div>
                    <div class="widget-subheading">All Sensors</div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-white count-animate" data-count="{{$count_sensor}}">0</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card mb-3 widget-content bg-midnight-bloom">
            <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                    <div class="widget-heading">Current Time</div>
                    <div class="widget-subheading">Real-time Clock</div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-white" id="real-time-clock"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Sensor Calibration Status</h5>
                <ul class="list-unstyled">
                    @foreach ($sensors as $sensor)
                    <li><i class="metismenu-icon bi "></i> {{$sensor->sensor}} : <strong>{{$sensor->status}}</strong></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Last Update Status</h5>
                <ul class="list-unstyled">
                    @foreach ($sensors as $sensor)
                    <li><i class="metismenu-icon bi bi-clock text-info"></i> {{$sensor->sensor}} : {{$sensor->updated_at->diffForHumans()}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div><br>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong>Kalibrasi Sensor</strong>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table style="width: 100%" class="align-middle mb-0 table-hover table data-table" id="users">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th class="no-sort action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sensors as $index => $sensor)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><p style="text-transform: uppercase;">{{ $sensor->sensor }}</p></td>
                                    <td>
                                        <a href="{{ route('admin.sensor.show', ['id' => $sensor->id]) }}">
                                            <button class="btn btn-primary">Generate Modus</button>
                                        </a>
                                        <a href="{{ route('admin.calibrate.show', ['id' => $sensor->id]) }}">
                                            <button class="btn btn-success">Calibrate</button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div><br>
@endsection

@push('js')
<script>
    // Fungsi untuk menganimasikan angka bertambah secara berurutan
    function animateValue(element, start, end, duration) {
        var range = end - start;
        var current = start;
        var increment = end > start ? 1 : -1;
        var stepTime = Math.abs(Math.floor(duration / range));
        var timer = setInterval(function () {
            current += increment;
            element.textContent = current;
            if (current == end) {
                clearInterval(timer);
            }
        }, stepTime);
    }

    // Memulai animasi ketika halaman dimuat
    document.addEventListener("DOMContentLoaded", function () {
        var countElements = document.querySelectorAll(".count-animate");
        countElements.forEach(function (element) {
            var startCount = parseInt(element.getAttribute("data-count"));
            animateValue(element, 0, startCount, 2000); // Menganimasikan selama 2 detik
        });
    });

    function updateRealTimeClock() {
        const clockElement = document.getElementById('real-time-clock');
        const now = new Date();
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const seconds = now.getSeconds().toString().padStart(2, '0');
        const timeString = `${hours}:${minutes}:${seconds}`;
        clockElement.textContent = timeString;
    }

    // Update jam setiap detik
    setInterval(updateRealTimeClock, 1000);

    // Panggil fungsi pertama kali untuk menampilkan jam awal
    updateRealTimeClock();

    // Simulasi suhu saat ini
    function updateCurrentTemperature() {
        const temperatureElement = document.getElementById('current-temperature');
        const randomTemperature = (Math.random() * 10 + 20).toFixed(1); // Suhu acak antara 20°C - 30°C
        temperatureElement.textContent = randomTemperature + '°C';
    }

    // Update suhu setiap 5 detik
    setInterval(updateCurrentTemperature, 5000);

    // Panggil fungsi pertama kali untuk menampilkan suhu awal
    updateCurrentTemperature();
</script>
@endpush
