<?php

use Illuminate\Support\Facades\Route;
use App\Models\Property;

Route::get('/', function () {

    $featuredProperties = Property::where('featured', true)
        ->latest()
        ->take(6)
        ->get();

    return view('pages.home', compact('featuredProperties'));

});

Route::get('/biens/{property}', function (Property $property) {

    return view('pages.property-show', compact('property'));

})->name('properties.show');