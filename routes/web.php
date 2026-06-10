<?php

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PropertyController;

Route::get('/', function () {
    $featuredProperties = Property::latest()
        ->take(6)
        ->get();

    return view('pages.home', compact('featuredProperties'));
});

Route::get('/admin', function () {
    $totalProperties = Property::count();
    $saleProperties = Property::where('transaction', 'vente')->count();
    $rentProperties = Property::where('transaction', 'location')->count();
    $landProperties = Property::where('type', 'terrain')->count();

    $latestProperties = Property::latest()
        ->take(5)
        ->get();

    return view('admin.dashboard', compact(
        'totalProperties',
        'saleProperties',
        'rentProperties',
        'landProperties',
        'latestProperties'
    ));
})->name('admin.dashboard');

Route::get(
    '/admin/properties/create',
    [PropertyController::class, 'create']
)->name('admin.properties.create');

Route::get(
    '/admin/properties/{property}/edit',
    [PropertyController::class, 'edit']
)->name('admin.properties.edit');

Route::put(
    '/admin/properties/{property}',
    [PropertyController::class, 'update']
)->name('admin.properties.update');

Route::post(
    '/admin/properties',
    [PropertyController::class, 'store']
)->name('admin.properties.store');

Route::delete(
    '/admin/properties/{property}',
    [PropertyController::class, 'destroy']
)->name('admin.properties.destroy');

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

    $property->load('images');

    return view('pages.property-show', compact('property'));

})->name('properties.show');