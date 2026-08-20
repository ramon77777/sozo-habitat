<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PropertyImage extends Model
{
    protected $fillable = [
        'property_id',
        'image_path',
        'is_main',
        'sort_order',
    ];

    protected $appends = [
        'url',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function getUrlAttribute(): string
    {
        if (str_starts_with($this->image_path, 'properties/')) {
            return Storage::disk(
                config('filesystems.media_disk', 'r2')
            )->url($this->image_path);
        }

        return asset(
            'images/properties/gallery/'.$this->image_path
        );
    }
}