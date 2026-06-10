@extends('layouts.app')

@section('content')

<section class="bg-[#F8F9FB] py-16 px-6 min-h-screen">
    <div class="max-w-5xl mx-auto">

        <div class="mb-10">
            <a href="/admin" class="text-[#0A2E5D] font-bold hover:text-[#C89B3C]">
                ← Retour au dashboard
            </a>

            <h1 class="text-5xl font-black text-[#0A2E5D] mt-4">
                Modifier le bien
            </h1>
        </div>

        <div class="bg-white rounded-3xl shadow-xl p-10">

            <form method="POST" action="{{ route('admin.properties.update', $property) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid md:grid-cols-2 gap-6">

                    <div>
                        <label class="block mb-2 font-semibold">Titre</label>
                        <input type="text" name="title" value="{{ old('title', $property->title) }}" class="w-full border border-slate-200 rounded-xl p-4">
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">Prix (FCFA)</label>
                        <input type="text" name="price" value="{{ old('price', $property->price) }}" class="w-full border border-slate-200 rounded-xl p-4">
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">Ville</label>
                        <input type="text" name="city" value="{{ old('city', $property->city) }}" class="w-full border border-slate-200 rounded-xl p-4">
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">Commune</label>
                        <input type="text" name="district" value="{{ old('district', $property->district) }}" class="w-full border border-slate-200 rounded-xl p-4">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block mb-2 font-semibold">Adresse / Quartier / Indication</label>
                        <input type="text" name="address" value="{{ old('address', $property->address) }}" class="w-full border border-slate-200 rounded-xl p-4">
                    </div>

                
                    <div>
                        <label class="block mb-2 font-semibold">Latitude</label>
                        <input id="latitude" type="text" name="latitude" value="{{ old('latitude', $property->latitude) }}" class="w-full border border-slate-200 rounded-xl p-4">
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">Longitude</label>
                        <input id="longitude" type="text" name="longitude" value="{{ old('longitude', $property->longitude) }}" class="w-full border border-slate-200 rounded-xl p-4">
                    </div>

                    <div class="md:col-span-2">
                        <button
                            type="button"
                            id="getLocationBtn"
                            class="rounded-xl bg-[#0A2E5D] px-6 py-4 font-bold text-white hover:bg-[#071F3F] transition"
                        >
                            📍 Utiliser ma position actuelle
                        </button>

                        <p class="mt-2 text-sm text-slate-500">
                            Le navigateur demandera l’autorisation d’accéder à votre position.
                        </p>
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">Surface (m²)</label>
                        <input type="text" name="surface" value="{{ old('surface', $property->surface) }}" class="w-full border border-slate-200 rounded-xl p-4">
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">Type</label>
                        <select id="propertyType" name="type" class="w-full border border-slate-200 rounded-xl p-4">
                            <option value="villa" @selected(old('type', $property->type) === 'villa')>Villa</option>
                            <option value="duplex" @selected(old('type', $property->type) === 'duplex')>Duplex</option>
                            <option value="appartement" @selected(old('type', $property->type) === 'appartement')>Appartement</option>
                            <option value="maison_basse" @selected(old('type', $property->type) === 'maison_basse')>Maison basse</option>
                            <option value="terrain" @selected(old('type', $property->type) === 'terrain')>Terrain</option>
                        </select>
                    </div>

                    <div id="housingFields" class="md:col-span-2">
                        <div class="grid md:grid-cols-5 gap-6">
                            <div>
                                <label class="block mb-2 font-semibold">Chambres</label>
                                <input type="text" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" class="w-full border border-slate-200 rounded-xl p-4">
                            </div>

                            <div>
                                <label class="block mb-2 font-semibold">Salles d'eau</label>
                                <input type="text" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" class="w-full border border-slate-200 rounded-xl p-4">
                            </div>

                            <div>
                                <label class="block mb-2 font-semibold">Salons</label>
                                <input type="text" name="living_rooms" value="{{ old('living_rooms', $property->living_rooms) }}" class="w-full border border-slate-200 rounded-xl p-4">
                            </div>

                            <div>
                                <label class="block mb-2 font-semibold">Cuisines</label>
                                <input type="text" name="kitchens" value="{{ old('kitchens', $property->kitchens) }}" class="w-full border border-slate-200 rounded-xl p-4">
                            </div>

                            <div>
                                <label class="block mb-2 font-semibold">Garages</label>
                                <input type="text" name="garages" value="{{ old('garages', $property->garages) }}" class="w-full border border-slate-200 rounded-xl p-4">
                            </div>
                        </div>
                    </div>

                    <div id="landFields" class="hidden md:col-span-2">
                        <div class="grid md:grid-cols-3 gap-6">
                            <div>
                                <label class="block mb-2 font-semibold">ACD disponible</label>
                                <select name="has_acd" class="w-full border border-slate-200 rounded-xl p-4">
                                    <option value="0" @selected(old('has_acd', $property->has_acd) == 0)>Non</option>
                                    <option value="1" @selected(old('has_acd', $property->has_acd) == 1)>Oui</option>
                                </select>
                            </div>

                            <div>
                                <label class="block mb-2 font-semibold">Lotissement approuvé</label>
                                <select name="is_lot_approved" class="w-full border border-slate-200 rounded-xl p-4">
                                    <option value="0" @selected(old('is_lot_approved', $property->is_lot_approved) == 0)>Non</option>
                                    <option value="1" @selected(old('is_lot_approved', $property->is_lot_approved) == 1)>Oui</option>
                                </select>
                            </div>

                            <div>
                                <label class="block mb-2 font-semibold">Type de document</label>
                                <input type="text" name="document_type" value="{{ old('document_type', $property->document_type) }}" class="w-full border border-slate-200 rounded-xl p-4">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">Transaction</label>
                        <select name="transaction" class="w-full border border-slate-200 rounded-xl p-4">
                            <option value="vente" @selected(old('transaction', $property->transaction) === 'vente')>Vente</option>
                            <option value="location" @selected(old('transaction', $property->transaction) === 'location')>Location</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">Image principale</label>
                        <input type="file" name="main_image" class="w-full border border-slate-200 rounded-xl p-4">

                        @if($property->main_image)
                            <p class="mt-2 text-sm text-slate-500">
                                Image actuelle : {{ $property->main_image }}
                            </p>
                        @endif
                    </div>

                    <div class="mt-4">
                        <label class="block mb-2 font-semibold">
                            Galerie photos
                        </label>

                        <input
                            type="file"
                            name="gallery_images[]"
                            multiple
                            accept="image/*"
                            class="w-full border border-slate-200 rounded-xl p-4"
                        >

                        <p class="mt-2 text-sm text-slate-500">
                            Vous pouvez sélectionner plusieurs images.
                        </p>
                    </div>

                </div>

                <div class="mt-4">
                    <label class="block mb-2 font-semibold">
                        Vidéos du bien
                    </label>

                    <input
                        type="file"
                        name="property_videos[]"
                        multiple
                        accept="video/mp4,video/webm,video/quicktime"
                        class="w-full border border-slate-200 rounded-xl p-4"
                    >

                    <p class="mt-2 text-sm text-slate-500">
                        Formats acceptés : MP4, WEBM, MOV.
                    </p>
                </div>

                <div class="mt-6">
                    <label class="block mb-2 font-semibold">Description</label>
                    <textarea name="description" rows="6" class="w-full border border-slate-200 rounded-xl p-4">{{ old('description', $property->description) }}</textarea>
                </div>

                <div class="mt-6 flex items-center gap-3">
                    <input type="checkbox" name="featured" value="1" @checked(old('featured', $property->featured))>
                    <span>Afficher dans les biens en vedette</span>
                </div>

                <button type="submit" class="mt-8 bg-[#C89B3C] hover:bg-[#A87F2E] text-white px-8 py-4 rounded-xl font-bold transition">
                    Enregistrer le bien
                </button>
            </form>

            @if ($errors->any())
                <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 p-5 text-red-700">
                    <p class="font-bold mb-3">Veuillez corriger les erreurs suivantes :</p>

                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('propertyType');
    const housingFields = document.getElementById('housingFields');
    const landFields = document.getElementById('landFields');
    const getLocationBtn = document.getElementById('getLocationBtn');
    const latitudeInput = document.getElementById('latitude');
    const longitudeInput = document.getElementById('longitude');

    function updateForm() {
        if (typeSelect.value === 'terrain') {
            housingFields.classList.add('hidden');
            landFields.classList.remove('hidden');
        } else {
            housingFields.classList.remove('hidden');
            landFields.classList.add('hidden');
        }
    }

    updateForm();

    typeSelect.addEventListener('change', updateForm);

    getLocationBtn.addEventListener('click', function () {
        if (!navigator.geolocation) {
            alert("La géolocalisation n'est pas supportée par ce navigateur.");
            return;
        }

        getLocationBtn.textContent = 'Récupération de la position...';

        navigator.geolocation.getCurrentPosition(
            function (position) {
                latitudeInput.value = position.coords.latitude;
                longitudeInput.value = position.coords.longitude;

                getLocationBtn.textContent = '📍 Position récupérée';
            },
            function () {
                alert("Impossible de récupérer votre position. Vérifiez l'autorisation du navigateur.");
                getLocationBtn.textContent = '📍 Utiliser ma position actuelle';
            }
        );
    });
});
</script>

@endsection