


<?php $__env->startSection('content'); ?>


<div class="p-8">


<div class="flex justify-between mb-8">

<h1 class="text-3xl font-black text-[#0A2E5D]">
Mes biens
</h1>


<a href="<?php echo e(route('agent.properties.create')); ?>"
class="bg-[#C89B3C] text-white px-6 py-3 rounded-full">

Ajouter un bien

</a>


</div>



<div class="bg-white rounded-3xl shadow p-6">


<table class="w-full">


<thead>

<tr>

<th class="text-left p-3">
Titre
</th>

<th>
Ville
</th>

<th>
Prix
</th>

<th>
Actions
</th>

</tr>

</thead>



<tbody>


<?php $__empty_1 = true; $__currentLoopData = $properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>


<tr class="border-b">


<td class="p-3">
<?php echo e($property->title); ?>

</td>


<td>
<?php echo e($property->city); ?>

</td>


<td>
<?php echo e(number_format($property->price)); ?> FCFA
</td>


<td>


<a href="<?php echo e(route('agent.properties.edit',$property)); ?>"
class="text-blue-600">

Modifier

</a>



<form action="<?php echo e(route('agent.properties.destroy',$property)); ?>"
method="POST"
class="inline">

<?php echo csrf_field(); ?>
<?php echo method_field('DELETE'); ?>


<button class="text-red-600 ml-3">

Supprimer

</button>


</form>


</td>


</tr>



<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

<tr>

<td colspan="4"
class="text-center p-5">

Aucun bien

</td>

</tr>


<?php endif; ?>


</tbody>


</table>


</div>


</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.agent', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\sozo-habitat\resources\views/agent/properties/index.blade.php ENDPATH**/ ?>