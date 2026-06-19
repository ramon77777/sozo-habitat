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
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Agent\PropertyController as AgentPropertyController;


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

Route::get('/sitemap.xml', [SitemapController::class, 'index'])
    ->name('sitemap');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:admin'])->group(function () {


    Route::get('/admin', function () {


        $totalProperties = Property::count();

        $saleProperties = Property::where('transaction','vente')->count();

        $rentProperties = Property::where('transaction','location')->count();

        $landProperties = Property::where('type','terrain')->count();

        $featuredPropertiesCount = Property::where('featured',true)->count();



        $totalInquiries = PropertyInquiry::count();

        $newInquiries = PropertyInquiry::where('is_processed',false)->count();



        $totalUsers = User::count();



        // Données graphiques

        $chartLabels = [];

        $monthlyInquiries = [];

        $monthlyProperties = [];



        for ($i = 5; $i >= 0; $i--) {


            $date = now()->subMonths($i);



            $chartLabels[] = ucfirst(
                $date->translatedFormat('M Y')
            );



            $monthlyInquiries[] = PropertyInquiry::whereYear(
                    'created_at',
                    $date->year
                )
                ->whereMonth(
                    'created_at',
                    $date->month
                )
                ->count();



            $monthlyProperties[] = Property::whereYear(
                    'created_at',
                    $date->year
                )
                ->whereMonth(
                    'created_at',
                    $date->month
                )
                ->count();

        }



        $transactionStats = [

            'Ventes' => $saleProperties,

            'Locations' => $rentProperties,

        ];



        $typeStats = [

            'Villas' => Property::where('type','villa')->count(),

            'Duplex' => Property::where('type','duplex')->count(),

            'Appartements' => Property::where('type','appartement')->count(),

            'Maisons basses' => Property::where('type','maison_basse')->count(),

            'Terrains' => $landProperties,

        ];



        $properties = Property::latest()
            ->paginate(10);



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



    Route::get('/dashboard', function(){

        return redirect()->route('admin.dashboard');

    })->name('dashboard');




    /*
    |--------------------------------------------------------------------------
    | Gestion biens
    |--------------------------------------------------------------------------
    */


    Route::get('/admin/properties', function (Request $request) {

        $propertiesQuery = Property::query();


        if ($request->filter === 'vente') {

            $propertiesQuery->where('transaction','vente');

        }


        if ($request->filter === 'location') {

            $propertiesQuery->where('transaction','location');

        }


        if ($request->filter === 'terrain') {

            $propertiesQuery->where('type','terrain');

        }


        if ($request->filter === 'featured') {

            $propertiesQuery->where('featured',true);

        }


        if ($request->search) {

            $propertiesQuery->where(function($query) use ($request){

                $query
                    ->where('title','like','%'.$request->search.'%')
                    ->orWhere('city','like','%'.$request->search.'%')
                    ->orWhere('district','like','%'.$request->search.'%')
                    ->orWhere('type','like','%'.$request->search.'%');

            });

        }


        $properties = $propertiesQuery
            ->latest()
            ->paginate(10)
            ->withQueryString();


        return view(
            'admin.properties.index',
            compact('properties')
        );


    })->name('admin.properties.index');


    /*
    |--------------------------------------------------------------------------
    | Gestion des biens
    |--------------------------------------------------------------------------
    */


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



    Route::patch(
        '/admin/properties/{property}/toggle-featured',
        function(Property $property){


            $property->update([

                'featured'=> !$property->featured,

                'featured_at'=> !$property->featured
                    ? now()
                    : null

            ]);


            return back();

        }

    )->name('admin.properties.toggle-featured');





    Route::get(
        '/admin/property-inquiries',
        [PropertyInquiryController::class,'index']
    )
    ->name('admin.property-inquiries.index');



    Route::get(
        '/admin/prospects',
        [ProspectController::class,'index']
    )
    ->name('admin.prospects.index');




    Route::get(
        '/admin/statistics',
        [StatisticsController::class,'index']
    )
    ->name('admin.statistics.index');



    Route::get(
        '/admin/site-settings',
        [SiteSettingController::class,'edit']
    )
    ->name('admin.site-settings.edit');



    Route::put(
        '/admin/site-settings',
        [SiteSettingController::class,'update']
    )
    ->name('admin.site-settings.update');



    Route::resource(
        'admin/users',
        UserController::class
    )
    ->names('admin.users');

    Route::get('/admin/featured-properties', function () {

        $featuredProperties = Property::where('featured', true)
            ->latest('featured_at')
            ->paginate(10);


        return view(
            'admin.featured-properties.index',
            compact('featuredProperties')
        );

    })->name('admin.featured-properties.index');


    /*
    |--------------------------------------------------------------------------
    | Demandes de visite
    |--------------------------------------------------------------------------
    */


    Route::get(
        '/admin/property-inquiries',
        [PropertyInquiryController::class, 'index']
    )
    ->name('admin.property-inquiries.index');



    Route::get(
        '/admin/property-inquiries/{propertyInquiry}',
        [PropertyInquiryController::class, 'show']
    )
    ->name('admin.property-inquiries.show');



    Route::patch(
        '/admin/property-inquiries/{propertyInquiry}/toggle',
        [PropertyInquiryController::class, 'toggle']
    )
    ->name('admin.property-inquiries.toggle');

    /*
    |--------------------------------------------------------------------------
    | Gestion prospects
    |--------------------------------------------------------------------------
    */


    Route::get(
        '/admin/prospects',
        [ProspectController::class, 'index']
    )
    ->name('admin.prospects.index');



    Route::patch(
        '/admin/prospects/{prospect}/status',
        [ProspectController::class, 'updateStatus']
    )
    ->name('admin.prospects.update-status');



    Route::patch(
        '/admin/prospects/{prospect}/assign',
        [ProspectController::class, 'assign']
    )
    ->name('admin.prospects.assign');

});





/*
|--------------------------------------------------------------------------
| AGENT
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:agent'])->group(function(){


    Route::get('/agent/dashboard', function(){


        $properties = Property::where('user_id', auth()->id())
            ->latest()
            ->paginate(5);


        $prospects = Prospect::where('assigned_to', auth()->id())
            ->latest()
            ->paginate(5);


        $totalProperties = Property::where(
            'user_id',
            auth()->id()
        )->count();


        $totalProspects = Prospect::where(
            'assigned_to',
            auth()->id()
        )->count();


        $newProspects = Prospect::where(
            'assigned_to',
            auth()->id()
        )
        ->where('status','nouveau')
        ->count();



        return view(
            'agent.dashboard',
            compact(
                'properties',
                'prospects',
                'totalProperties',
                'totalProspects',
                'newProspects'
            )
        );


    })->name('agent.dashboard');




    /*
    |--------------------------------------------------------------------------
    | Biens de l'agent
    |--------------------------------------------------------------------------
    */


    Route::middleware(['auth','role:agent'])
    ->prefix('agent')
    ->name('agent.')
    ->group(function(){


        Route::resource(
            'properties',
            AgentPropertyController::class
        );


    });






    /*
    |--------------------------------------------------------------------------
    | Prospects agent
    |--------------------------------------------------------------------------
    */


    Route::get('/agent/prospects', function () {


        $prospects = Prospect::where(
            'assigned_to',
            auth()->id()
        )
        ->latest()
        ->paginate(10);



        return view(
            'agent.prospects.index',
            compact('prospects')
        );


    })->name('agent.prospects.index');







    /*
    |--------------------------------------------------------------------------
    | Rendez-vous agent
    |--------------------------------------------------------------------------
    */


    Route::get('/agent/appointments', function () {


        $appointments = PropertyInquiry::whereHas(
            'property',
            function ($query) {

                $query->where(
                    'user_id',
                    auth()->id()
                );

            }
        )
        ->latest()
        ->paginate(10);



        return view(
            'agent.appointments.index',
            compact('appointments')
        );


    })->name('agent.appointments.index');



});


/*
|--------------------------------------------------------------------------
| PROFIL UTILISATEUR
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function(){


    Route::get('/profile', function(){


        return view('profile.edit');


    })->name('profile.edit');



    Route::patch('/profile', function(Request $request){


        $validated = $request->validate([

            'name'=>['required','string','max:255'],

            'email'=>[
                'required',
                'email',
                'max:255'
            ],

        ]);



        auth()->user()->update($validated);



        return back()->with(
            'success',
            'Profil mis à jour.'
        );


    })->name('profile.update');




    Route::put('/profile/password', function(Request $request){


        $request->validate([

            'current_password'=>'required',

            'password'=>[
                'required',
                'confirmed',
                'min:8'
            ],

        ]);



        if(
            !Hash::check(
                $request->current_password,
                auth()->user()->password
            )
        ){

            return back()->withErrors([
                'current_password'
                =>
                'Mot de passe actuel incorrect.'
            ]);

        }



        auth()->user()->update([

            'password'=>Hash::make(
                $request->password
            )

        ]);



        return back()->with(
            'success',
            'Mot de passe modifié.'
        );


    })->name('profile.password');



});

require __DIR__.'/auth.php';