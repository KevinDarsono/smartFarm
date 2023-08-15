<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    protected $table = "sensor_jenis";

    protected $fillable = [

        'sensor',
        'status',
        'created_at',
        'updated_at',

    ];

    protected $keyType = 'string';

    protected function kalibrasi(){
        return $this->hasMany(Kalibrasi::class);
    }
}
