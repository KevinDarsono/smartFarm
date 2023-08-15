<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sensor;
use App\Models\HasilKalibrasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CalibrateController extends Controller
{
    public function show($id)
    {

        $sensor = Sensor::findOrFail($id);
        $dataKalibrasi = HasilKalibrasi::where('id_sensor', $id)->get();

        $data = [
            'sensor' => $sensor,
        ];

        return view('admin.calibrate.show', compact("data"));

    }

    public function getData(Request $request, $id)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $startTime = $request->input('start_time'); // Timestamp for start time
        $endTime = $request->input('end_time'); // Timestamp for end time

        $startTimestamp = strtotime($startDate . ' ' . $startTime);
        $endTimestamp = strtotime($endDate . ' ' . $endTime);

        $startDateTime = Carbon::createFromTimestamp($startTimestamp);
        $endDateTime = Carbon::createFromTimestamp($endTimestamp);

        $dataKalibrasi = HasilKalibrasi::where('id_sensor', $id)
        ->whereBetween('created_at', [$startDateTime, $endDateTime])->get();


        $xValues = $dataKalibrasi->pluck('modus')->toArray();
        $yValues = $dataKalibrasi->pluck('alat_ukur')->toArray();

        $dataToSend = [
            'x' => $xValues,
            'y' => $yValues,
        ];

        $flaskResponse = Http::post('http://localhost:5000/linear_regression', $dataToSend);

        $linearRegressionResult = $flaskResponse->json();
        $slope = $linearRegressionResult['slope'];
        $intercept = $linearRegressionResult['intercept'];

        $sensor = Sensor::findOrFail($id);

        $data = [
            'dataKalibrasi' => $dataKalibrasi,
            'startDate' => $startDate,
            'startTime' => $startTime,
            'endDate' => $endDate,
            'endTime' => $endTime,
            'sensor' => $sensor,
            'slope' => $slope,
            'intercept' => $intercept,
            'tableDisplayed' => true,
        ];

        // Pass the fetched data and input values back to the view
        return view('admin.calibrate.show', $data);
    }


}
