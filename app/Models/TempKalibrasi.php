<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempKalibrasi extends Model
{
    use HasFactory;

    protected $table = 'kalibrasi_temp';

    protected $fillable = [
        'id_kalibrasi',
        'created_at',
        'updated_at,'
    ];

    protected $keyType = 'string';

    public function kalibrasi(){
        return $this->belongsTo(Kalibrasi::class);
    }


}
