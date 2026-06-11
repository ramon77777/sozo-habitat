<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prospect extends Model
{
    protected $fillable = [
        'property_id',
        'assigned_to',
        'name',
        'phone',
        'email',
        'status',
        'notes',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}