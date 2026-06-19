

<?php $__env->startSection('content'); ?>

<div class="max-w-7xl mx-auto py-12 px-6">

    <div class="flex items-center justify-between mb-8">
        <div>
            <a href="<?php echo e(route('admin.dashboard')); ?>"
               class="text-[#0A2E5D] font-bold hover:text-[#C89B3C]">
                ← Retour au dashboard
            </a>

            <h1 class="text-4xl font-black text-[#0A2E5D] mt-4">
                Demandes de visite
            </h1>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-left">

                <thead class="bg-slate-100 text-[#0A2E5D]">
                    <tr>
                        <th class="p-4">Bien</th>
                        <th class="p-4">Nom</th>
                        <th class="p-4">Téléphone</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Date</th>
                        <th class="p-4">Statut</th>
                        <th class="p-4">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $inquiries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inquiry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <tr class="border-t border-slate-100">

                            <td class="p-4 font-semibold text-[#0A2E5D]">
                                <?php echo e($inquiry->property->title ?? 'Bien supprimé'); ?>

                            </td>

                            <td class="p-4 font-semibold">
                                <?php echo e($inquiry->name); ?>

                            </td>

                            <td class="p-4">
                                <a href="tel:<?php echo e($inquiry->phone); ?>"
                                   class="text-[#0A2E5D] font-bold hover:text-[#C89B3C]">
                                    <?php echo e($inquiry->phone); ?>

                                </a>
                            </td>

                            <td class="p-4">
                                <?php if($inquiry->email): ?>
                                    <a href="mailto:<?php echo e($inquiry->email); ?>"
                                       class="text-[#0A2E5D] hover:text-[#C89B3C]">
                                        <?php echo e($inquiry->email); ?>

                                    </a>
                                <?php else: ?>
                                    <span class="text-slate-400">Non renseigné</span>
                                <?php endif; ?>
                            </td>

                            <td class="p-4 text-slate-600">
                                <?php echo e($inquiry->created_at->format('d/m/Y H:i')); ?>

                            </td>

                            <td class="p-4">
                                <?php if($inquiry->is_processed): ?>
                                    <span class="inline-flex px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-sm font-bold">
                                        Traité
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-bold">
                                        Nouveau
                                    </span>
                                <?php endif; ?>
                            </td>

                            <td class="p-4">
                                <div class="flex gap-2">

                                    <a
                                        href="<?php echo e(route('admin.property-inquiries.show', $inquiry)); ?>"
                                        class="px-4 py-2 rounded-xl bg-slate-200 text-slate-700 font-semibold hover:bg-slate-300"
                                    >
                                        Voir
                                    </a>

                                    <form
                                        action="<?php echo e(route('admin.property-inquiries.toggle', $inquiry)); ?>"
                                        method="POST"
                                    >
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>

                                        <button
                                            type="submit"
                                            class="px-4 py-2 rounded-xl bg-[#0A2E5D] text-white font-semibold hover:bg-[#071F3F]"
                                        >
                                            <?php echo e($inquiry->status === 'new' ? 'Traiter' : 'Réouvrir'); ?>

                                        </button>

                                    </form>

                                </div>
                            </td>

                        </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-500">
                                Aucune demande enregistrée
                            </td>
                        </tr>

                    <?php endif; ?>
                </tbody>

            </table>
        </div>

    </div>

    <div class="mt-6">
        <?php echo e($inquiries->links()); ?>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\sozo-habitat\resources\views/admin/property-inquiries/index.blade.php ENDPATH**/ ?>