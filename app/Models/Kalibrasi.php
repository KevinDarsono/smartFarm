<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kalibrasi extends Model
{
    use HasFactory;

    protected $table = 'kalibrasi_data';

    protected $guarded = [''];

    protected $keyType = 'string';


    public function sensor(){
        return $this->belongsTo(Sensor::class, 'id');
    }
}
