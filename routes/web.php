<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\PropertyInquiryController;
use App\Mail\NewPropertyInquiryMail;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyInquiry;
use App\Models\PropertyVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
    $property->load(['images', 'videos']);

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

Route::middleware(['auth'])->group(function () {

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

    Route::get('/dashboard', function () {
        return redirect()->route('admin.dashboard');
    })->name('dashboard');

    Route::get(
        '/admin/properties/create',
        [PropertyController::class, 'create']
    )->name('admin.properties.create');

    Route::post(
        '/admin/properties',
        [PropertyController::class, 'store']
    )->name('admin.properties.store');

    Route::get(
        '/admin/properties/{property}/edit',
        [PropertyController::class, 'edit']
    )->name('admin.properties.edit');

    Route::put(
        '/admin/properties/{property}',
        [PropertyController::class, 'update']
    )->name('admin.properties.update');

    Route::delete(
        '/admin/properties/{property}',
        [PropertyController::class, 'destroy']
    )->name('admin.properties.destroy');

    Route::get(
        '/admin/property-inquiries',
        [PropertyInquiryController::class, 'index']
    )->name('admin.property-inquiries.index');

    Route::get(
        '/admin/property-inquiries/{propertyInquiry}',
        [PropertyInquiryController::class, 'show']
    )->name('admin.property-inquiries.show');

    Route::patch(
        '/admin/property-inquiries/{inquiry}/toggle',
        [PropertyInquiryController::class, 'toggle']
    )->name('admin.property-inquiries.toggle');

    Route::delete('/admin/property-images/{image}', function (PropertyImage $image) {
        $path = public_path('images/properties/gallery/' . $image->image_path);

        if ($image->image_path && file_exists($path)) {
            unlink($path);
        }

        $image->delete();

        return back()->with('success', 'Image supprimée avec succès.');
    })->name('admin.property-images.destroy');

    Route::delete('/admin/property-videos/{video}', function (PropertyVideo $video) {
        $path = public_path('videos/properties/' . $video->video_path);

        if ($video->video_path && file_exists($path)) {
            unlink($path);
        }

        $video->delete();

        return back()->with('success', 'Vidéo supprimée avec succès.');
    })->name('admin.property-videos.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';