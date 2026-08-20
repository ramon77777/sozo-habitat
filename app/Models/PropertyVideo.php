<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PropertyVideo extends Model
{
    protected $fillable = [
        'property_id',
        'video_path',
        'title',
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
        if (str_starts_with($this->video_path, 'properties/')) {
            return Storage::disk(
                config('filesystems.media_disk', 'r2')
            )->url($this->video_path);
        }

        return asset(
            'videos/properties/'.$this->video_path
        );
    }
}