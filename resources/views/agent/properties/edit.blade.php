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






<form method="POST"

action="{{ route('agent.properties.update',$property) }}"

enctype="multipart/form-data">


@csrf

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

name="main_image"

class="w-full border rounded-xl p-4">


</div>






<div>

<label class="font-semibold">

Ajouter des images

</label>


<input

type="file"

multiple

name="gallery_images[]"

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

name="property_videos[]"

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