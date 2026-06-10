<?php

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PropertyController;

use App\Models\PropertyInquiry;

use App\Http\Controllers\Admin\PropertyInquiryController;

use Illuminate\Support\Facades\Mail;
use App\Mail\NewPropertyInquiryMail;

Route::get('/', function () {
    $featuredProperties = Property::latest()
        ->take(6)
        ->get();

    return view('pages.home', compact('featuredProperties'));
});

Route::get('/admin', function (Request $request) {
    $totalProperties = Property::count();
    $saleProperties = Property::where('transaction', 'vente')->count();
    $rentProperties = Property::where('transaction', 'location')->count();
    $landProperties = Property::where('type', 'terrain')->count();

    $totalInquiries = PropertyInquiry::count();
    $newInquiries = PropertyInquiry::where('is_processed', false)->count();

    $propertiesQuery = Property::query();

    if ($request->filter === 'vente') {
        $propertiesQuery->where('transaction', 'vente');
    }

    if ($request->filter === 'location') {
        $propertiesQuery->where('transaction', 'location');
    }

    if ($request->filter === 'terrain') {
        $propertiesQuery->where('type', 'terrain');
    }

    if ($request->filter === 'featured') {
        $propertiesQuery->where('featured', true);
    }

    if ($request->search) {
        $propertiesQuery->where(function ($query) use ($request) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('city', 'like', '%' . $request->search . '%')
                ->orWhere('district', 'like', '%' . $request->search . '%')
                ->orWhere('type', 'like', '%' . $request->search . '%');
        });
    }

    $properties = $propertiesQuery
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view('admin.dashboard', compact(
        'totalProperties',
        'saleProperties',
        'rentProperties',
        'landProperties',
        'totalInquiries',
        'newInquiries',
        'properties'
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

Route::post('/biens/{property}/demande-visite', function (Request $request, Property $property) {
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'phone' => ['required', 'string', 'max:30'],
        'email' => ['nullable', 'email', 'max:255'],
        'message' => ['nullable', 'string', 'max:2000'],
    ]);

    $inquiry = $property->inquiries()->create($validated);

    Mail::to('sororamon01@gmail.com')
        ->send(new NewPropertyInquiryMail($inquiry));

    return back()->with('success', 'Votre demande a bien été envoyée. Nous vous contacterons rapidement.');
})->name('properties.inquiries.store');

Route::get(
    '/admin/property-inquiries',
    [PropertyInquiryController::class, 'index']
)->name('admin.property-inquiries.index');

Route::patch(
    '/admin/property-inquiries/{inquiry}/toggle',
    [PropertyInquiryController::class, 'toggle']
)->name('admin.property-inquiries.toggle');

Route::get(
    '/admin/property-inquiries/{propertyInquiry}',
    [PropertyInquiryController::class, 'show']
)->name('admin.property-inquiries.show');

