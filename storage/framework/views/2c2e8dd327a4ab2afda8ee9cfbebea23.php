

<?php $__env->startSection('content'); ?>

<section class="bg-[#F8F9FB] py-16 px-6 min-h-screen">

<div class="max-w-5xl mx-auto">


<div class="mb-10">

<a href="<?php echo e(route('agent.properties.index')); ?>"
class="text-[#0A2E5D] font-bold hover:text-[#C89B3C]">

← Retour à mes biens

</a>


<h1 class="text-5xl font-black text-[#0A2E5D] mt-4">
Ajouter un bien
</h1>


</div>




<div class="bg-white rounded-3xl shadow-xl p-10">


<?php if($errors->any()): ?>

<div class="mb-6 rounded-2xl bg-red-50 p-5 text-red-700">

<ul class="list-disc pl-5">

<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<li><?php echo e($error); ?></li>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</ul>

</div>

<?php endif; ?>





<form method="POST"
action="<?php echo e(route('agent.properties.store')); ?>"
enctype="multipart/form-data">


<?php echo csrf_field(); ?>



<div class="grid md:grid-cols-2 gap-6">



<div>

<label class="font-semibold">
Titre
</label>


<input
name="title"
class="w-full border rounded-xl p-4">

</div>




<div>

<label class="font-semibold">
Prix (FCFA)
</label>


<input
type="number"
name="price"
class="w-full border rounded-xl p-4">

</div>





<div>

<label class="font-semibold">
Ville
</label>


<input
name="city"
class="w-full border rounded-xl p-4">

</div>





<div>

<label class="font-semibold">
Commune
</label>


<input
name="district"
class="w-full border rounded-xl p-4">

</div>





<div class="md:col-span-2">


<label class="font-semibold">
Adresse / Quartier
</label>


<input
name="address"
class="w-full border rounded-xl p-4">


</div>






<div>
    <label class="block mb-2 font-semibold">
        Latitude
    </label>

    <input
        id="latitude"
        type="text"
        name="latitude"
        class="w-full border border-slate-200 rounded-xl p-4"
        placeholder="Ex : 5.3599517"
    >
</div>


<div>
    <label class="block mb-2 font-semibold">
        Longitude
    </label>

    <input
        id="longitude"
        type="text"
        name="longitude"
        class="w-full border border-slate-200 rounded-xl p-4"
        placeholder="Ex : -4.0082563"
    >
</div>




<div class="md:col-span-2">

    <button
        type="button"
        id="getLocationBtn"
        class="rounded-xl bg-[#0A2E5D] px-6 py-4 font-bold text-white"
    >
        📍 Utiliser ma position actuelle
    </button>


    <p class="text-sm text-slate-500 mt-2">
        Autorisez l'accès à la localisation dans votre navigateur.
    </p>

</div>





<div>

<label class="font-semibold">
Surface m²
</label>


<input
type="number"
name="surface"
class="w-full border rounded-xl p-4">

</div>





<div>

<label class="font-semibold">
Type
</label>


<select
name="type"
id="propertyType"
class="w-full border rounded-xl p-4">


<option value="villa">
Villa
</option>


<option value="duplex">
Duplex
</option>


<option value="appartement">
Appartement
</option>


<option value="maison_basse">
Maison basse
</option>


<option value="terrain">
Terrain
</option>


</select>

</div>




<div>

<label class="font-semibold">
Transaction
</label>


<select
name="transaction"
class="w-full border rounded-xl p-4">


<option value="vente">
Vente
</option>


<option value="location">
Location
</option>


</select>

</div>




<div>

<label class="font-semibold">
Image principale
</label>


<input
type="file"
name="main_image"
class="w-full border rounded-xl p-4">


</div>





<div>

<label class="font-semibold">
Galerie photos
</label>


<input
multiple
type="file"
name="gallery_images[]"
class="w-full border rounded-xl p-4">


</div>



</div>






<div class="mt-6">


<label class="font-semibold">
Vidéos
</label>


<input
multiple
type="file"
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
class="w-full border rounded-xl p-4"></textarea>


</div>






<button

class="mt-8 bg-[#C89B3C] text-white px-8 py-4 rounded-xl font-bold">

Enregistrer

</button>



</form>


</div>



</div>


</section>

<script>

document.addEventListener('DOMContentLoaded', function(){


    const button = document.getElementById('getLocationBtn');

    const latitude = document.getElementById('latitude');

    const longitude = document.getElementById('longitude');



    button.addEventListener('click', function(){


        if(!navigator.geolocation){

            alert(
                "La géolocalisation n'est pas disponible."
            );

            return;

        }



        button.innerHTML =
        "📍 Récupération en cours...";



        navigator.geolocation.getCurrentPosition(


            function(position){


                latitude.value =
                    position.coords.latitude;


                longitude.value =
                    position.coords.longitude;



                button.innerHTML =
                "✅ Position récupérée";


            },



            function(error){


                console.log(error);



                alert(
                    "Impossible de récupérer la position. Vérifiez l'autorisation du navigateur."
                );



                button.innerHTML =
                "📍 Utiliser ma position actuelle";


            },


            {
                enableHighAccuracy:true,
                timeout:10000,
                maximumAge:0
            }

        );



    });


});


</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.agent', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\sozo-habitat\resources\views/agent/properties/create.blade.php ENDPATH**/ ?>