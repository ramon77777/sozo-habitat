<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyInquiry extends Model
{
    protected $fillable = [
        'property_id',
        'name',
        'phone',
        'email',
        'message',
        'is_processed',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}