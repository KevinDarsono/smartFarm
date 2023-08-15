<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kalibrasi;
use App\Models\Sensor;
use App\Imports\SensorImport;
use Maatwebsite\Excel\Facades\Excel;


class ExcelController extends Controller
{
    public function importExcel(Request $request, $sensorId)
    {
        $file = $request->file('file');

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        $import = new SensorImport($sensorId);

        try {
            Excel::import($import, $file);
            $dataToImport = $import->getDataToImport();
            $errors = $import->getErrors();

            if (!empty($dataToImport) && empty($errors)) {
                // Tambahkan timestamp di setiap entri yang akan diinsert
                $timestampedData = [];
                foreach ($dataToImport as $data) {
                    $timestampedData[] = array_merge($data, [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                Kalibrasi::insert($timestampedData);

                Sensor::where('id', $sensorId)->update(['status' => 'Data Sudah di Upload']);
                $message = 'Data berhasil diupload.';
                Session::flash('import_message', $message);
                return back()->with('import_success', true);
            } elseif (!empty($errors)) {
                $errorMessage = implode('<br>', $errors);
                Session::flash('import_error', $errorMessage);
                return back()->with('import_error', $errorMessage);
            } else {
                $message = 'Data gagal diupload.';
                Session::flash('import_message', $message);
                return back();
            }
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];

            foreach ($failures as $failure) {
                $errorMessages[] = "Baris {$failure->row()}: {$failure->errors()[0]}";
            }

            $errorMessage = implode('<br>', $errorMessages);
            Session::flash('import_error', $errorMessage);

            return back()->with('import_error', $errorMessage);
        }
    }

}
