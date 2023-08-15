<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    public $incrementing = false;

    // In Laravel 6.0+ make sure to also set $keyType
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'land_id',
        'lon',
        'lat'
    ];

    public function land()
    {
        return $this->belongsTo(Land::class);
    }

    public function sensor()
    {
        return $this->hasOne(Sensor::class);
    }
}
