<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'logo',
        'email',
        'phone_1',
        'phone_2',
        'whatsapp',
        'address',
        'facebook',
        'instagram',
        'linkedin',
        'tiktok',
        'youtube',
        'meta_title',
        'meta_description',
    ];
}