

<?php $__env->startSection('content'); ?>


<div class="p-8">


<h1 class="text-4xl font-black text-[#0A2E5D]">
Bonjour <?php echo e(auth()->user()->name); ?>

</h1>

<p class="text-slate-500 mt-2">
Espace agent Sozo Habitat
</p>



<div class="grid md:grid-cols-3 gap-6 mt-10">


    <div class="bg-white rounded-3xl shadow p-6">

    <h3 class="font-bold">
        Mes biens
    </h3>

    <p class="text-5xl font-black mt-3 text-[#0A2E5D]">
        <?php echo e($totalProperties); ?>

    </p>

    <a href="<?php echo e(route('agent.properties.index')); ?>"
        class="text-sm text-blue-600 mt-3 inline-block">
        Voir mes biens →
    </a>

</div>



<div class="bg-white rounded-3xl shadow p-6">

    <h3 class="font-bold">
         Mes clients
    </h3>

    <p class="text-5xl font-black mt-3 text-[#0A2E5D]">
        <?php echo e($totalProspects); ?>

    </p>

    <a href="<?php echo e(route('agent.prospects.index')); ?>"
        class="text-sm text-blue-600 mt-3 inline-block">
         Voir mes clients →
    </a>

</div>




<div class="bg-white rounded-3xl shadow p-6">

    <h3 class="font-bold">
        Nouveaux contacts
    </h3>

    <p class="text-5xl font-black mt-3 text-[#C89B3C]">
        <?php echo e($newProspects); ?>

    </p>

</div>



</div>





<div class="mt-12 bg-white rounded-3xl shadow p-6">


<h2 class="text-2xl font-black mb-6">
Mes derniers biens
</h2>



<table class="w-full">

<thead>

<tr class="text-left border-b">

<th class="p-3">
Titre
</th>


<th>
Ville
</th>


<th>
Prix
</th>


</tr>

</thead>


<tbody>


<?php $__empty_1 = true; $__currentLoopData = $properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>


<tr class="border-b">


<td class="p-3 font-bold">

<?php echo e($property->title); ?>


</td>


<td>

<?php echo e($property->city); ?>


</td>


<td>

<?php echo e(number_format($property->price,0,' ',' ')); ?> FCFA

</td>


</tr>


<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>


<tr>

<td colspan="3" class="p-5 text-center text-slate-400">

Aucun bien attribué

</td>

</tr>


<?php endif; ?>


</tbody>

</table>


</div>






<div class="mt-10 bg-white rounded-3xl shadow p-6">


<h2 class="text-2xl font-black mb-6">
Mes clients
</h2>



<table class="w-full">


<thead>

<tr class="border-b text-left">


<th class="p-3">
Nom
</th>


<th>
Téléphone
</th>


<th>
Statut
</th>


</tr>


</thead>


<tbody>


<?php $__empty_1 = true; $__currentLoopData = $prospects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prospect): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>


<tr class="border-b">


<td class="p-3">
<?php echo e($prospect->name); ?>

</td>


<td>
<?php echo e($prospect->phone); ?>

</td>


<td>

<span class="px-3 py-1 rounded-full bg-slate-100">

<?php echo e($prospect->status); ?>


</span>


</td>


</tr>



<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>


<tr>

<td colspan="3" class="p-5 text-center text-slate-400">

Aucun client

</td>

</tr>


<?php endif; ?>



</tbody>



</table>


</div>



</div>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.agent', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\sozo-habitat\resources\views/agent/dashboard.blade.php ENDPATH**/ ?>