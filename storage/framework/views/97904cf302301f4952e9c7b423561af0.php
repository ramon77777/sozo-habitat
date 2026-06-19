<?php $__env->startSection('content'); ?>


<div class="p-8 max-w-5xl">


<h1 class="text-4xl font-black text-[#0A2E5D]">
Mon profil
</h1>


<p class="text-slate-500 mt-2">
Gestion de mes informations agent Sozo Habitat
</p>



<?php if(session('success')): ?>

<div class="mt-6 bg-green-100 text-green-700 p-4 rounded-xl">

<?php echo e(session('success')); ?>


</div>

<?php endif; ?>





<div class="mt-10 bg-white rounded-3xl shadow p-8">


<h2 class="text-2xl font-black mb-6">

Informations personnelles

</h2>



<form method="POST"
action="<?php echo e(route('profile.update')); ?>">


<?php echo csrf_field(); ?>

<?php echo method_field('PATCH'); ?>



<label class="font-bold">
Nom
</label>


<input
name="name"
value="<?php echo e(auth()->user()->name); ?>"
class="w-full mt-2 mb-5 rounded-xl border p-3">





<label class="font-bold">
Email
</label>


<input
name="email"
value="<?php echo e(auth()->user()->email); ?>"
class="w-full mt-2 rounded-xl border p-3">





<button
class="mt-6 bg-[#0A2E5D] text-white px-6 py-3 rounded-xl font-bold">

Enregistrer

</button>



</form>


</div>








<div class="mt-8 bg-white rounded-3xl shadow p-8">


<h2 class="text-2xl font-black mb-6">

Changer mon mot de passe

</h2>



<form method="POST"
action="<?php echo e(route('profile.password')); ?>">


<?php echo csrf_field(); ?>

<?php echo method_field('PUT'); ?>



<input
type="password"
name="current_password"
placeholder="Ancien mot de passe"
class="w-full mb-4 rounded-xl border p-3">



<input
type="password"
name="password"
placeholder="Nouveau mot de passe"
class="w-full mb-4 rounded-xl border p-3">



<input
type="password"
name="password_confirmation"
placeholder="Confirmation"
class="w-full rounded-xl border p-3">





<button
class="mt-6 bg-[#C89B3C] text-white px-6 py-3 rounded-xl font-bold">

Modifier

</button>



</form>


</div>



</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.agent', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\sozo-habitat\resources\views/profile/edit.blade.php ENDPATH**/ ?>