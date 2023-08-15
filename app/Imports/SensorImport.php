<?php

namespace App\Imports;

use App\Models\Kalibrasi;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Crypt;


class SensorImport implements WithHeadingRow, ToCollection
{
    private $sensorId;
    private $dataToImport = [];
    private $errors = [];

    public function __construct($sensorId)
    {
        $this->sensorId = $sensorId;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (empty($row['data_sensor'])) {
                $this->errors[] = 'Data sensor harus diisi';
                continue;
            }

            $this->dataToImport[] = [
                'id_sensor' => $this->sensorId,
                'data_sensor' => $row['data_sensor'],
                // tambahkan kolom-kolom lain yang diperlukan
            ];
        }
    }

    public function getDataToImport()
    {
        return $this->dataToImport;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
