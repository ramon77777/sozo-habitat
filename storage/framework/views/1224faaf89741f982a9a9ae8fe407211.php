

<?php $__env->startSection('content'); ?>


<section class="bg-[#F8F9FB] py-16 px-6 min-h-screen">


<div class="max-w-5xl mx-auto">


<div class="mb-10">


<a href="<?php echo e(route('agent.properties.index')); ?>"
class="text-[#0A2E5D] font-bold hover:text-[#C89B3C]">

← Retour à mes biens

</a>



<h1 class="text-5xl font-black text-[#0A2E5D] mt-4">

Modifier le bien

</h1>


</div>





<div class="bg-white rounded-3xl shadow-xl p-10">



<?php if($errors->any()): ?>

<div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-5 text-red-700">

<ul class="list-disc pl-5">

<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<li><?php echo e($error); ?></li>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</ul>

</div>

<?php endif; ?>






<form method="POST"

action="<?php echo e(route('agent.properties.update',$property)); ?>"

enctype="multipart/form-data">


<?php echo csrf_field(); ?>

<?php echo method_field('PUT'); ?>





<div class="grid md:grid-cols-2 gap-6">





<div>

<label class="font-semibold">
Titre
</label>


<input

name="title"

value="<?php echo e(old('title',$property->title)); ?>"

class="w-full border rounded-xl p-4">


</div>






<div>

<label class="font-semibold">
Prix (FCFA)
</label>


<input

type="number"

name="price"

value="<?php echo e(old('price',$property->price)); ?>"

class="w-full border rounded-xl p-4">


</div>






<div>

<label class="font-semibold">
Ville
</label>


<input

name="city"

value="<?php echo e(old('city',$property->city)); ?>"

class="w-full border rounded-xl p-4">


</div>






<div>

<label class="font-semibold">
Commune
</label>


<input

name="district"

value="<?php echo e(old('district',$property->district)); ?>"

class="w-full border rounded-xl p-4">


</div>






<div class="md:col-span-2">


<label class="font-semibold">

Adresse / Quartier

</label>


<input

name="address"

value="<?php echo e(old('address',$property->address)); ?>"

class="w-full border rounded-xl p-4">


</div>







<div>

<label class="font-semibold">
Latitude
</label>


<input

id="latitude"

name="latitude"

value="<?php echo e(old('latitude',$property->latitude)); ?>"

class="w-full border rounded-xl p-4">


</div>





<div>

<label class="font-semibold">
Longitude
</label>


<input

id="longitude"

name="longitude"

value="<?php echo e(old('longitude',$property->longitude)); ?>"

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

value="<?php echo e(old('surface',$property->surface)); ?>"

class="w-full border rounded-xl p-4">


</div>






<div>

<label class="font-semibold">
Type
</label>


<select

name="type"

class="w-full border rounded-xl p-4">



<?php $__currentLoopData = [
'villa'=>'Villa',
'duplex'=>'Duplex',
'appartement'=>'Appartement',
'maison_basse'=>'Maison basse',
'terrain'=>'Terrain'
]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


<option

value="<?php echo e($key); ?>"

<?php if($property->type==$key): ?>
selected
<?php endif; ?>

>

<?php echo e($label); ?>


</option>


<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


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
<?php if($property->transaction=='vente'): ?> selected <?php endif; ?>>

Vente

</option>



<option value="location"
<?php if($property->transaction=='location'): ?> selected <?php endif; ?>>

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

<?php echo e(old('description',$property->description)); ?>


</textarea>


</div>








<button

class="mt-8 bg-[#C89B3C] text-white px-8 py-4 rounded-xl font-bold">

Mettre à jour

</button>




<a

href="<?php echo e(route('agent.properties.index')); ?>"

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



<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.agent', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\sozo-habitat\resources\views/agent/properties/edit.blade.php ENDPATH**/ ?>