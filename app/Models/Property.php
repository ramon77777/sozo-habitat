<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'title',
        'price',
        'city',
        'district',
        'surface',
        'bedrooms',
        'bathrooms',
        'type',
        'transaction',
        'description',
        'main_image',
        'featured',
    ];
}

