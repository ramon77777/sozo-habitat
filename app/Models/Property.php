<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Property extends Model
{
    protected $fillable = [
        'user_id',
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

    protected $appends = [
        'main_image_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function videos()
    {
        return $this->hasMany(PropertyVideo::class);
    }

    public function inquiries()
    {
        return $this->hasMany(PropertyInquiry::class);
    }

    public function getMainImageUrlAttribute(): ?string
    {
        if (! $this->main_image) {
            return null;
        }

        if (str_starts_with($this->main_image, 'properties/')) {
            return Storage::disk(
                config('filesystems.media_disk', 'r2')
            )->url($this->main_image);
        }

        return asset(
            'images/properties/'.$this->main_image
        );
    }
}