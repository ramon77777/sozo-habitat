<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PropertyImage;
use App\Models\PropertyVideo;

class Property extends Model
{
    protected $fillable = [
        'title',
        'price',
        'city',
        'district',
        'address',
        'latitude',
        'longitude',
        'surface',
        'bedrooms',
        'bathrooms',
        'living_rooms',
        'kitchens',
        'garages',
        'type',
        'transaction',
        'description',
        'main_image',
        'featured',
        'has_acd',
        'is_lot_approved',
        'document_type',
    ];

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function videos()
    {
        return $this->hasMany(PropertyVideo::class);
    }
}

