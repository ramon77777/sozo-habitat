<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyVideo extends Model
{
    protected $fillable = [
        'property_id',
        'video_path',
        'title',
        'sort_order',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}