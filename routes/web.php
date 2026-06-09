<?php

use App\Models\Property;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $featuredProperties = Property::latest()
        ->take(3)
        ->get();

    return view('pages.home', compact('featuredProperties'));
});