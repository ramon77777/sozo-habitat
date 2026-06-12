<?php

use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\PropertyInquiryController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Mail\NewPropertyInquiryMail;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyInquiry;
use App\Models\PropertyVideo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\StatisticsController;
use App\Models\Prospect;
use App\Http\Controllers\Admin\ProspectController;


Route::get('/', function () {
    $featuredProperties = Property::where('featured', true)
        ->latest()
        ->take(10)
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

    Prospect::create([
        'property_id' => $property->id,
        'name' => $validated['name'],
        'phone' => $validated['phone'],
        'email' => $validated['email'] ?? null,
        'status' => 'nouveau',
        'notes' => $validated['message'] ?? null,
    ]);

    Mail::to('sororamon01@gmail.com')
        ->send(new NewPropertyInquiryMail($inquiry));

    return back()->with('success', 'Votre demande a bien été envoyée. Nous vous contacterons rapidement.');
})->name('properties.inquiries.store');

Route::middleware(['auth','admin'])->group(function () {

   Route::get('/admin', function (Request $request) {
        $totalProperties = Property::count();
        $saleProperties = Property::where('transaction', 'vente')->count();
        $rentProperties = Property::where('transaction', 'location')->count();
        $landProperties = Property::where('type', 'terrain')->count();
        $featuredPropertiesCount = Property::where('featured', true)->count();

        $totalInquiries = PropertyInquiry::count();
        $newInquiries = PropertyInquiry::where('is_processed', false)->count();

        $totalUsers = User::count();

        $chartLabels = [];
        $monthlyInquiries = [];
        $monthlyProperties = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);

            $chartLabels[] = ucfirst($date->translatedFormat('M Y'));

            $monthlyInquiries[] = PropertyInquiry::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $monthlyProperties[] = Property::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        $transactionStats = [
            'Ventes' => $saleProperties,
            'Locations' => $rentProperties,
        ];

        $typeStats = [
            'Villas' => Property::where('type', 'villa')->count(),
            'Duplex' => Property::where('type', 'duplex')->count(),
            'Appartements' => Property::where('type', 'appartement')->count(),
            'Maisons basses' => Property::where('type', 'maison_basse')->count(),
            'Terrains' => $landProperties,
        ];

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
            'featuredPropertiesCount',
            'totalInquiries',
            'newInquiries',
            'totalUsers',
            'chartLabels',
            'monthlyInquiries',
            'monthlyProperties',
            'transactionStats',
            'typeStats',
            'properties'
        ));
    })->name('admin.dashboard');

    Route::get('/dashboard', function () {
        return redirect()->route('admin.dashboard');
    })->name('dashboard');

    Route::get('/admin/properties', function (Request $request) {
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

        return view('admin.properties.index', compact('properties'));
    })->name('admin.properties.index');

    Route::get('/admin/properties/create', [PropertyController::class, 'create'])
        ->name('admin.properties.create');

    Route::post('/admin/properties', [PropertyController::class, 'store'])
        ->name('admin.properties.store');

    Route::get('/admin/properties/{property}/edit', [PropertyController::class, 'edit'])
        ->name('admin.properties.edit');

    Route::put('/admin/properties/{property}', [PropertyController::class, 'update'])
        ->name('admin.properties.update');

    Route::delete('/admin/properties/{property}', [PropertyController::class, 'destroy'])
        ->name('admin.properties.destroy');

    Route::patch('/admin/properties/{property}/toggle-featured', function (Property $property) {

        $featured = !$property->featured;

        $property->update([
            'featured' => $featured,
            'featured_at' => $featured ? now() : null,
        ]);

        return back()->with(
            'success',
            $featured
                ? 'Le bien a été ajouté aux vedettes.'
                : 'Le bien a été retiré des vedettes.'
        );

    })->name('admin.properties.toggle-featured');

    Route::get('/admin/property-inquiries', [PropertyInquiryController::class, 'index'])
        ->name('admin.property-inquiries.index');

    Route::get('/admin/property-inquiries/{propertyInquiry}', [PropertyInquiryController::class, 'show'])
        ->name('admin.property-inquiries.show');

    Route::patch('/admin/property-inquiries/{inquiry}/toggle', [PropertyInquiryController::class, 'toggle'])
        ->name('admin.property-inquiries.toggle');
    
    Route::get('/admin/prospects', [ProspectController::class, 'index'])
    ->name('admin.prospects.index');

    Route::patch('/admin/prospects/{prospect}/status', [ProspectController::class, 'updateStatus'])
        ->name('admin.prospects.update-status');

    Route::patch('/admin/prospects/{prospect}/assign', [ProspectController::class, 'assign'])
        ->name('admin.prospects.assign');

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

    
    Route::get('/admin/featured-properties', function () {
            $featuredProperties = Property::where('featured', true)
                ->latest('featured_at')
                ->paginate(10);

            return view('admin.featured-properties.index', compact('featuredProperties'));
        })->name('admin.featured-properties.index');
    });

    Route::get(
        '/admin/statistics',
        [StatisticsController::class, 'index']
    )->name('admin.statistics.index');

    Route::get('/admin/site-settings', [SiteSettingController::class, 'edit'])
        ->name('admin.site-settings.edit');

    Route::put('/admin/site-settings', [SiteSettingController::class, 'update'])
        ->name('admin.site-settings.update');

    Route::get('/admin/users', [UserController::class, 'index'])
        ->name('admin.users.index');

    Route::get('/admin/users/create', [UserController::class, 'create'])
        ->name('admin.users.create');

    Route::post('/admin/users', [UserController::class, 'store'])
        ->name('admin.users.store');

    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])
        ->name('admin.users.edit');

    Route::put('/admin/users/{user}', [UserController::class, 'update'])
        ->name('admin.users.update');

    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])
        ->name('admin.users.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


require __DIR__.'/auth.php';