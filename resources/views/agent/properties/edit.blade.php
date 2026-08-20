@extends('layouts.agent')

@section('content')


<section class="bg-[#F8F9FB] py-16 px-6 min-h-screen">


<div class="max-w-5xl mx-auto">


<div class="mb-10">


<a href="{{ route('agent.properties.index') }}"
class="text-[#0A2E5D] font-bold hover:text-[#C89B3C]">

← Retour à mes biens

</a>



<h1 class="text-5xl font-black text-[#0A2E5D] mt-4">

Modifier le bien

</h1>


</div>





<div class="bg-white rounded-3xl shadow-xl p-10">



@if ($errors->any())

<div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-5 text-red-700">

<ul class="list-disc pl-5">

@foreach($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach

</ul>

</div>

@endif






<form
method="POST"
action="{{ route('agent.properties.update',$property) }}"
enctype="multipart/form-data"
data-media-upload-form
data-presign-url="{{ route('media.uploads.presign') }}"
data-existing-main-image="{{ $property->main_image ? 1 : 0 }}"
data-existing-gallery-count="{{ $property->images->count() }}"
data-existing-video-count="{{ $property->videos->count() }}">


@csrf

@if(old('main_image_key'))
<input
type="hidden"
name="main_image_key"
value="{{ old('main_image_key') }}"
data-existing-upload-key="main_image"
>
@endif

@foreach((array) old('gallery_image_keys', []) as $uploadedKey)
<input
type="hidden"
name="gallery_image_keys[]"
value="{{ $uploadedKey }}"
data-existing-upload-key="gallery_image"
>
@endforeach

@foreach((array) old('property_video_keys', []) as $uploadedKey)
<input
type="hidden"
name="property_video_keys[]"
value="{{ $uploadedKey }}"
data-existing-upload-key="property_video"
>
@endforeach

@method('PUT')





<div class="grid md:grid-cols-2 gap-6">





<div>

<label class="font-semibold">
Titre
</label>


<input

name="title"

value="{{ old('title',$property->title) }}"

class="w-full border rounded-xl p-4">


</div>






<div>

<label class="font-semibold">
Prix (FCFA)
</label>


<input

type="number"

name="price"

value="{{ old('price',$property->price) }}"

class="w-full border rounded-xl p-4">


</div>






<div>

<label class="font-semibold">
Ville
</label>


<input

name="city"

value="{{ old('city',$property->city) }}"

class="w-full border rounded-xl p-4">


</div>






<div>

<label class="font-semibold">
Commune
</label>


<input

name="district"

value="{{ old('district',$property->district) }}"

class="w-full border rounded-xl p-4">


</div>






<div class="md:col-span-2">


<label class="font-semibold">

Adresse / Quartier

</label>


<input

name="address"

value="{{ old('address',$property->address) }}"

class="w-full border rounded-xl p-4">


</div>







<div>

<label class="font-semibold">
Latitude
</label>


<input

id="latitude"

name="latitude"

value="{{ old('latitude',$property->latitude) }}"

class="w-full border rounded-xl p-4">


</div>





<div>

<label class="font-semibold">
Longitude
</label>


<input

id="longitude"

name="longitude"

value="{{ old('longitude',$property->longitude) }}"

class="w-full border rounded-xl p-4">


</div>






<div class="md:col-span-2">


<button

type="button"

id="getLocationBtn"

class="bg-[#0A2E5D] text-white px-6 py-3 rounded-xl">

📍 Mettre à jour ma position

</button>


</div>






<div>

<label class="font-semibold">

Surface m²

</label>


<input

type="number"

name="surface"

value="{{ old('surface',$property->surface) }}"

class="w-full border rounded-xl p-4">


</div>






<div>

<label class="font-semibold">
Type
</label>


<select

name="type"

class="w-full border rounded-xl p-4">



@foreach([
'villa'=>'Villa',
'duplex'=>'Duplex',
'appartement'=>'Appartement',
'maison_basse'=>'Maison basse',
'terrain'=>'Terrain'
] as $key=>$label)


<option

value="{{ $key }}"

@if($property->type==$key)
selected
@endif

>

{{ $label }}

</option>


@endforeach


</select>


</div>






<div>

<label class="font-semibold">

Transaction

</label>


<select

name="transaction"

class="w-full border rounded-xl p-4">



<option value="vente"
@if($property->transaction=='vente') selected @endif>

Vente

</option>



<option value="location"
@if($property->transaction=='location') selected @endif>

Location

</option>


</select>


</div>






<div>

<label class="font-semibold">

Nouvelle image principale

</label>


<input

type="file"

data-media-category="main_image"

class="w-full border rounded-xl p-4">


</div>






<div>

<label class="font-semibold">

Ajouter des images

</label>


<input

type="file"

multiple

data-media-category="gallery_image"

class="w-full border rounded-xl p-4">


</div>



</div>







<div class="mt-6">


<label class="font-semibold">

Ajouter des vidéos

</label>


<input

type="file"

multiple

data-media-category="property_video"

class="w-full border rounded-xl p-4">


</div>







<div class="mt-6">


<label class="font-semibold">

Description

</label>


<textarea

name="description"

rows="6"

class="w-full border rounded-xl p-4">

{{ old('description',$property->description) }}

</textarea>


</div>








<button

class="mt-8 bg-[#C89B3C] text-white px-8 py-4 rounded-xl font-bold">

Mettre à jour

</button>




<a

href="{{ route('agent.properties.index') }}"

class="ml-5 text-slate-500">

Annuler

</a>






</form>

@if($property->main_image || $property->images->count() || $property->videos->count())
<div class="mt-12 border-t border-slate-100 pt-10">

    @if($property->main_image)
        <h3 class="mb-4 text-2xl font-black text-[#0A2E5D]">
            Image principale actuelle
        </h3>

        <img
            src="{{ $property->main_image_url }}"
            alt="{{ $property->title }}"
            class="mb-8 h-56 w-full rounded-2xl object-cover"
        >
    @endif

    @if($property->images->count())
        <h3 class="mb-4 text-2xl font-black text-[#0A2E5D]">
            Images de la galerie
        </h3>

        <div class="grid gap-4 md:grid-cols-4">
            @foreach($property->images as $image)
                <div class="rounded-2xl border border-slate-200 p-3">
                    <img
                        src="{{ $image->url }}"
                        class="h-32 w-full rounded-xl object-cover"
                        alt=""
                    >

                    <form
                        method="POST"
                        action="{{ route('agent.property-images.destroy', $image) }}"
                        onsubmit="return confirm('Supprimer cette image ?')"
                        class="mt-3"
                    >
                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="w-full rounded-xl bg-red-600 px-4 py-2 font-bold text-white"
                        >
                            Supprimer
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif

    @if($property->videos->count())
        <h3 class="mb-4 mt-10 text-2xl font-black text-[#0A2E5D]">
            Vidéos du bien
        </h3>

        <div class="grid gap-4 md:grid-cols-2">
            @foreach($property->videos as $video)
                <div class="rounded-2xl border border-slate-200 p-3">
                    <div class="aspect-video overflow-hidden rounded-xl bg-black">
                        <video controls class="h-full w-full object-contain">
                            <source src="{{ $video->url }}">
                        </video>
                    </div>

                    <form
                        method="POST"
                        action="{{ route('agent.property-videos.destroy', $video) }}"
                        onsubmit="return confirm('Supprimer cette vidéo ?')"
                        class="mt-3"
                    >
                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="w-full rounded-xl bg-red-600 px-4 py-2 font-bold text-white"
                        >
                            Supprimer
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endif

</div>

</div>

</section>





<script>

document.addEventListener('DOMContentLoaded',()=>{


const btn=document.getElementById('getLocationBtn');


const lat=document.getElementById('latitude');

const lng=document.getElementById('longitude');



btn.addEventListener('click',()=>{


navigator.geolocation.getCurrentPosition((position)=>{


lat.value=position.coords.latitude;

lng.value=position.coords.longitude;


btn.innerHTML="📍 Position mise à jour";


});


});



});


</script>



@endsection