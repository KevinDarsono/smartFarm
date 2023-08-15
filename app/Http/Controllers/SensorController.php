<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Kalibrasi;
use App\Models\HasilKalibrasi;
use App\Models\Sensor;
use GuzzleHttp\Client;



class SensorController extends Controller
{
    public function index(){
        $count_sensor = Sensor::count();
        $sensors = Sensor::all();

        return view('admin.sensor.index', compact('count_sensor', 'sensors'));

    }

    public function showWithDataRange($id)
    {
        $sensor = Sensor::findOrFail($id);
        $excelData = [];

        $data = [
            'sensor' => $sensor,
            'excelData' => $excelData,
        ];

        return view('admin.sensor.show', compact("data"));

    }


    public function update(Request $request, $id)
    {
        try {
            $cek = "0";

            if (is_array($request->start_date)) {
                foreach ($request->start_date as $key => $start_data) {
                    $startDateTime = Carbon::parse($request->input('start_date')[$key] . ' ' . $request->input('start_time')[$key]);
                    $endDateTime = Carbon::parse($request->input('end_date')[$key] . ' ' . $request->input('end_time')[$key]);
                    $alatUkur = $request->input('alat_ukur')[$key]; // Inputan alat ukur tunggal

                    if (is_array($alatUkur)) {
                        $alatUkurSingle = $alatUkur;
                    } else {
                        $alatUkurSingle = $alatUkur;
                    }

                    $kalibrasi = Kalibrasi::where("id_sensor", $id)
                    ->whereBetween("created_at", [$startDateTime, $endDateTime])
                    ->get();

                    if (!empty($kalibrasi)) {
                        // Proses denoised sebelum menghitung modus
                        $kalibrasiData = $kalibrasi->pluck('data_sensor')->toArray();


                        $url = 'http://127.0.0.1:5000/denoisedPost';
                        $data = [
                            'signal' => $kalibrasiData,
                            'denoised_method' => 'dwt' // Ubah sesuai metode denoised yang Anda inginkan
                        ];

                        $client = new Client();
                        $response = $client->post($url, [
                            'json' => $data
                        ]);

                        $denoised_data = json_decode($response->getBody(), true);

                        $data_nn = $denoised_data['denoised_signal'];

                        // proses DWT
                        $url = 'http://127.0.0.1:5000/denoisedPost';
                        $data = [
                            'signal' => $data_nn,
                            'denoised_method' => 'dwt' // Ubah sesuai metode denoised yang Anda inginkan
                        ];

                        $client = new Client();
                        $response = $client->post($url, [
                            'json' => $data
                        ]);

                        $denoised_data_dwt = json_decode($response->getBody(), true);

                        $data_sensor = $denoised_data_dwt['denoised_signal'];

                        $data_sensor = array_map('intval', $data_sensor);
                        $modus = array_count_values($data_sensor);
                        arsort($modus);
                        $nn_modus = key($modus);

                        $id_kalibrasi = Kalibrasi::first();

                        HasilKalibrasi::create([
                            "id_kalibrasi" => $id_kalibrasi->id,
                            "id_sensor" => $id,
                            "modus" => $nn_modus,
                            "alat_ukur" => $alatUkurSingle,
                            "start_date" => $request->start_date[$key],
                            "end_date" => $request->end_date[$key],
                            "start_time" => $request->start_time[$key],
                            "end_time" => $request->end_time[$key]
                        ]);

                        $cek = "1";
                    } else {
                        $sensor = Sensor::where("id_sensor", $id)->first();

                        $data = [
                            'sensor' => $sensor,
                            'dataCount' => 0,
                            'nn_modus' => null,
                            'alat_ukur' => $alatUkurSingle,
                        ];

                        $cek = "0";
                    }
                }
            } else {
                $startDateTime = Carbon::parse($request->start_date . ' ' . $request->start_time);
                $endDateTime = Carbon::parse($request->end_date . ' ' . $request->end_time);
                $alatUkurSingle = $request->alat_ukur;

                $kalibrasi = Kalibrasi::where("id_sensor", $id)
                ->whereBetween("created_at", [$startDateTime, $endDateTime])
                ->get();

                if (!empty($kalibrasi)) {
                    // Proses denoised sebelum menghitung modus
                    $kalibrasiData = $kalibrasi->pluck('data_sensor')->toArray();

                    // proses NN
                    $url = 'http://127.0.0.1:5000/denoisedPost';
                    $data = [
                        'signal' => $kalibrasiData,
                        'denoised_method' => 'nn' // Ubah sesuai metode denoised yang Anda inginkan
                    ];

                    $client = new Client();
                    $response = $client->post($url, [
                        'json' => $data
                    ]);

                    $denoised_data = json_decode($response->getBody(), true);

                    $data_nn = $denoised_data['denoised_signal'];

                    // proses DWT
                    $url = 'http://127.0.0.1:5000/denoisedPost';
                    $data = [
                        'signal' => $data_nn,
                        'denoised_method' => 'dwt' // Ubah sesuai metode denoised yang Anda inginkan
                    ];

                    $client = new Client();
                    $response = $client->post($url, [
                        'json' => $data
                    ]);

                    $denoised_data_dwt = json_decode($response->getBody(), true);

                    $data_sensor = $denoised_data_dwt['denoised_signal'];
                    // Ubah tipe data menjadi integer jika diperlukan
                    $data_sensor = array_map('intval', $data_sensor);
                    // Hitung modus dari data_sensor yang sudah di-denoised
                    $modus = array_count_values($data_sensor);
                    arsort($modus);
                    $nn_modus = key($modus);

                    $id_kalibrasi = Kalibrasi::first();

                    HasilKalibrasi::create([
                        "id_kalibrasi" => $id_kalibrasi->id,
                        "id_sensor" => $id,
                        "modus" => $nn_modus,
                        "alat_ukur" => $alatUkurSingle,
                        "start_date" => $request->start_date,
                        "end_date" => $request->end_date,
                        "start_time" => $request->start_time,
                        "end_time" => $request->end_time
                    ]);

                    $cek = "1";
                } else {
                    $sensor = Sensor::where("id_sensor", $id)->first();

                    $data = [
                        'sensor' => $sensor,
                        'dataCount' => 0,
                        'nn_modus' => null,
                        'alat_ukur' => $alatUkurSingle,
                    ];

                    $cek = "0";
                }
            }

            if ($cek == "1") {
                return back()->with("message", "Data Ditemukan");
            } else if ($cek == "0") {
                return back()->with("message", "Data Tidak Ditemukan");
            }

        } catch (\Exception $e) {
            dd($e);
        }
    }


}



