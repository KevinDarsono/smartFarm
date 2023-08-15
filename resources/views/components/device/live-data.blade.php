<div class="row">
    <div class="col-md-12 mb-4">
        <button id="getRecommendation" class="btn btn-primary">Dapatkan Rekomendasi Tindakan</button>
        <div id="badgeRecommendation" class="mb-2 mr-2 badge badge-info"></div>
        <div id="badgeRecommendation2" class="mb-2 mr-2 badge badge-info"></div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Temperatur Udara</h4>
            </div>
            <div class="card-body">
                <canvas id="tempChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Intensitas Cahaya</h4>
            </div>
            <div class="card-body">
                <canvas id="lightChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Curah Hujan</h4>
            </div>
            <div class="card-body">
                <canvas id="rainfallChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Kecepatan Angin</h4>
            </div>
            <div class="card-body">
                <canvas id="windSpeedChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Kadar Air</h4>
            </div>
            <div class="card-body">
                <canvas id="waterPhChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Kadar Air Pada Tanah</h4>
            </div>
            <div class="card-body">
                <canvas id="soilPhChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Kelembapan Udara</h4>
            </div>
            <div class="card-body">
                <canvas id="humidityChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Kelembapan Tanah</h4>
            </div>
            <div class="card-body">
                <canvas id="soilMoistureChart"></canvas>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mqtt/4.3.7/mqtt.min.js"
        integrity="sha512-tc5xpAPaQDl/Uxd7ZVbV66v94Lys0IefMJSdlABPuzyCv0IXmr9TkqEQvZiWKRoXMSlP5YPRwpq2a+v5q2uzMg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js"></script>

    {{-- datalable plugin --}}
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

    {{-- streaming pluugin --}}
    <script src="https://cdn.jsdelivr.net/npm/luxon@1.27.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@1.0.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-streaming@2.0.0"></script>
    <script>
        $("#getRecommendation").click(function() {

            let features = [
                parseFloat(sensors.temp.data[sensors.temp.data.length - 1]),
                parseFloat(sensors.humidity.data[sensors.humidity.data.length - 1]),
                parseFloat(sensors.soil_moisture.data[sensors.soil_moisture.data.length - 1]),
                {{ $land->crop_age }}
            ]

            // console.log(features);

            $('#getRecommendation').prop('disabled', true);
            $("#badgeRecommendation").html('<i class="bi bi-arrow-repeat"></i>');
            $.ajax({
                url: '{{ env('RECOMMENDATION_HOST') }}/rice/predict',
                type: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                data: JSON.stringify({
                    'features': features
                }),
                success: function(data) {
                    $('#getRecommendation').prop('disabled', false);
                    if (data.prediction >= '0.5') {
                        $("#badgeRecommendation").addClass("badge-success")
                        $("#badgeRecommendation").text('Perlu Penyiraman');
                    } else {
                        $("#badgeRecommendation").addClass("badge-info")
                        $("#badgeRecommendation").text('Tidak Perlu Penyiraman');
                    }
                    $("#badgeRecommendation").show();
                },
                error: function(error) {
                    $('#getRecommendation').prop('disabled', false);
                    console.log(error);
                }
            });
        });
    </script>

    <script>
        // Global Plugin Register
        Chart.register(ChartDataLabels);
        Chart.register(ChartStreaming);

        // MQTT Setup
        var options = {
            clean: true,
            connectTimeout: 4000,
            clientId: 'test',
            username: '{{ env('MQTT_USERNAME') }}',
            password: '{{ env('MQTT_PASSWORD') }}',
        }
        const protocol = '{{ env('MQTT_PROTOCOL') }}';
        const host = '{{ env('MQTT_HOST') }}';
        const port = '{{ env('MQTT_PORT') }}';
        const topic = '{{ env('MQTT_TOPIC') }}/{{ $device->id }}';

        var client = mqtt.connect(`${protocol}://${host}:${port}`, options)

        client.on('connect', function() {
            console.log('Websocket Connected')
            client.subscribe(topic)
        })

        let sensors = {
            temp: {
                ctx: document.getElementById('tempChart').getContext('2d'),
                name: 'Temperatur Udara',
                data: [],
                time: [],
                chart: null,
                gradient: null,
            },
            humidity: {
                ctx: document.getElementById('humidityChart').getContext('2d'),
                name: 'Kelembapan',
                data: [],
                time: [],
                chart: null,
                gradient: null,
            },
            soil_moisture: {
                ctx: document.getElementById('soilMoistureChart').getContext('2d'),
                name: 'Kelembapan Tanah',
                data: [],
                time: [],
                chart: null,
                gradient: null,
            },
            soil_ph: {
                ctx: document.getElementById('soilPhChart').getContext('2d'),
                name: 'Kadar Air Pada Tanah',
                data: [],
                time: [],
                chart: null,
                gradient: null,
            },
            water_ph: {
                ctx: document.getElementById('waterPhChart').getContext('2d'),
                name: 'Kadar Air',
                data: [],
                time: [],
                chart: null,
                gradient: null,
            },
            light: {
                ctx: document.getElementById('lightChart').getContext('2d'),
                name: 'Intensitas Cahaya',
                data: [],
                time: [],
                chart: null,
                gradient: null,
            },
            wind_speed: {
                ctx: document.getElementById('windSpeedChart').getContext('2d'),
                name: 'Kecepatan Angin',
                data: [],
                time: [],
                chart: null,
                gradient: null,
            },
            rainfall: {
                ctx: document.getElementById('rainfallChart').getContext('2d'),
                name: 'Curah Hujan',
                data: [],
                time: [],
                chart: null,
                gradient: null,
            },
        }

        var liveDataOptions = {
            plugins: {
                legend: {
                    display: false
                },
                datalabels: {
                    borderRadius: 4,
                    color: 'white',
                    font: {
                        weight: 'bold'
                    },
                    padding: 6,
                    backgroundColor: function(context) {
                        return context.dataset.backgroundColor;
                    },
                },
                streaming: {
                    duration: 20000
                }
            },
            scales: {
                x: {
                    type: 'realtime',
                    realtime: {
                        duration: 20000
                    }
                }
            },
            responsive: true,
            tension: 0.3,
        }


        for (sensor in sensors) {
            sensors[sensor].gradient = sensors[sensor].ctx.createLinearGradient(0, 0, 0, 400);
            sensors[sensor].gradient.addColorStop(0, 'rgba(250,174,50,1)');
            sensors[sensor].gradient.addColorStop(1, 'rgba(250,174,50,0)');

            sensors[sensor].chart = new Chart(sensors[sensor].ctx, {
                type: 'line',
                data: {
                    labels: sensors[sensor].time,
                    datasets: [{
                        label: sensors[sensor].name,
                        data: sensors[sensor].data,
                        backgroundColor: sensors[sensor].gradient,
                        fill: true,
                        spanGaps: true,
                    }]
                },
                options: liveDataOptions,
            });
        }

        // The action after reveiving message
        client.on('message', function(topic, message) {
            var today = new Date();
            var timeNow = ('0' + today.getHours()).slice(-2) + ":" + ('0' + today.getMinutes()).slice(-2) + ":" + (
                '0' + today.getSeconds()).slice(-2);
            try {
                let msg = message.toString().split(',')
                let sensorData = msg.splice(1, 8)
                // console.log(timeNow)
                for (sensor in sensors) {
                    sensors[sensor].chart.data.labels.push(timeNow) //msg[3]
                    sensors[sensor].chart.data.datasets[0].data.push(sensorData[Object.keys(sensors).indexOf(
                        sensor)])
                    sensors[sensor].chart.update()
                }
            } catch (error) {
                console.log("Error " + error);
            }
        })
    </script>
    <script>
        class Node {
            constructor(val, priority) {
                this.val = val;
                this.priority = priority;
            }
        }
    </script>
@endpush
