<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Land extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'polygon',
        'area',
        'crop_status',
        'crop_planted_at'
    ];

    protected $appends = [
        'image'
    ];

    protected function defaultImageUrl(){
        return url('blank.png');
    }

    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('land-images') ? $this->getFirstMediaUrl('land-images') : $this->defaultImageUrl();
    }

    public function getCropAgeAttribute()
    {
        $date1 = new \DateTime($this->crop_planted_at);
        $date2 = new \DateTime(date('Y-m-d'));
        $diff = $date1->diff($date2);
        return $diff->format('%a');
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function user()
    {
        return $this->belongsTo("App\Models\User", "user_id", "id");
    }
}
