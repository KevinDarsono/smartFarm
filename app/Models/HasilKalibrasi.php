<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilKalibrasi extends Model
{
    use HasFactory;

    protected $table = 'kalibrasi_hasil';

    protected $guarded = [''];

    public function Kalibrasi(){
        return $this->belongsTo(Sensor::class, 'id_sensor');
    }


}
