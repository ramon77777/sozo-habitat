<?php

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $featuredProperties = Property::latest()
        ->take(6)
        ->get();

    return view('pages.home', compact('featuredProperties'));
});

Route::get('/biens', function (Request $request) {
    $properties = Property::query()
        ->when($request->type, fn ($query) => $query->where('type', $request->type))
        ->when($request->transaction, fn ($query) => $query->where('transaction', $request->transaction))
        ->when($request->city, fn ($query) => $query->where('city', 'like', '%' . $request->city . '%'))
        ->when($request->min_price, fn ($query) => $query->where('price', '>=', $request->min_price))
        ->when($request->max_price, fn ($query) => $query->where('price', '<=', $request->max_price))
        ->latest()
        ->get();

    return view('pages.properties', compact('properties'));
})->name('properties.index');

Route::get('/biens/{property}', function (Property $property) {
    return view('pages.property-show', compact('property'));
})->name('properties.show');