

<?php $__env->startSection('content'); ?>

<div class="p-8">


<h1 class="text-3xl font-black text-[#0A2E5D]">
Mes rendez-vous
</h1>

<p class="text-slate-500 mt-2">
Demandes de visite reçues sur mes biens
</p>



<div class="mt-10 bg-white rounded-3xl shadow p-6">


<table class="w-full">

<thead>

<tr class="border-b text-left">

<th class="p-3">
Client
</th>

<th>
Téléphone
</th>

<th>
Bien
</th>

<th>
Date
</th>

</tr>

</thead>



<tbody>


<?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>


<tr class="border-b">


<td class="p-3 font-bold">

<?php echo e($appointment->name); ?>


</td>


<td>

<?php echo e($appointment->phone); ?>


</td>


<td>

<?php echo e($appointment->property->title ?? '-'); ?>


</td>


<td>

<?php echo e($appointment->created_at->format('d/m/Y')); ?>


</td>


</tr>


<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>


<tr>

<td colspan="4"
class="p-5 text-center text-slate-400">

Aucun rendez-vous

</td>

</tr>


<?php endif; ?>


</tbody>


</table>


</div>


</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.agent', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\sozo-habitat\resources\views/agent/appointments/index.blade.php ENDPATH**/ ?>