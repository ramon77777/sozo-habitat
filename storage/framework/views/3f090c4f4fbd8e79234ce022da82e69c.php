

<?php $__env->startSection('content'); ?>

<section class="min-h-screen bg-[#F8F9FB] px-6 py-10">

    <div class="max-w-7xl mx-auto">

        <div class="mb-10">
            <p class="text-[#C89B3C] font-bold uppercase tracking-[0.3em]">
                Administration
            </p>

            <h1 class="text-4xl font-black text-[#0A2E5D] mt-3">
                Statistiques avancées
            </h1>
        </div>

        
        <div class="grid md:grid-cols-3 lg:grid-cols-6 gap-6 mb-10">

            <div class="bg-white rounded-3xl p-6 shadow">
                <p class="text-slate-500">Total biens</p>
                <h2 class="text-4xl font-black text-[#0A2E5D] mt-3">
                    <?php echo e($totalProperties); ?>

                </h2>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow">
                <p class="text-slate-500">Biens vedettes</p>
                <h2 class="text-4xl font-black text-[#C89B3C] mt-3">
                    <?php echo e($featuredProperties); ?>

                </h2>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow">
                <p class="text-slate-500">Demandes reçues</p>
                <h2 class="text-4xl font-black text-green-600 mt-3">
                    <?php echo e($totalInquiries); ?>

                </h2>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow">
                <p class="text-slate-500">Demandes traitées</p>
                <h2 class="text-4xl font-black text-[#0A2E5D] mt-3">
                    <?php echo e($processedInquiries); ?>

                </h2>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow">
                <p class="text-slate-500">En attente</p>
                <h2 class="text-4xl font-black text-red-600 mt-3">
                    <?php echo e($pendingInquiries); ?>

                </h2>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow">
                <p class="text-slate-500">Taux traitement</p>
                <h2 class="text-4xl font-black text-[#C89B3C] mt-3">
                    <?php echo e($processingRate); ?>%
                </h2>
            </div>

        </div>

        
        <div class="grid lg:grid-cols-2 gap-8">

            <div class="bg-white rounded-3xl shadow p-6">
                <h2 class="text-2xl font-black text-[#0A2E5D] mb-6">
                    Demandes de visite sur 12 mois
                </h2>

                <canvas id="monthlyInquiriesChart" height="140"></canvas>
            </div>

            <div class="bg-white rounded-3xl shadow p-6">
                <h2 class="text-2xl font-black text-[#0A2E5D] mb-6">
                    Biens ajoutés sur 12 mois
                </h2>

                <canvas id="monthlyPropertiesChart" height="140"></canvas>
            </div>

            <div class="bg-white rounded-3xl shadow p-6">
                <h2 class="text-2xl font-black text-[#0A2E5D] mb-6">
                    Ventes / Locations
                </h2>

                <div class="max-w-xs mx-auto">
                    <canvas id="transactionChart" height="220"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow p-6">
                <h2 class="text-2xl font-black text-[#0A2E5D] mb-6">
                    Types de biens
                </h2>

                <canvas id="typeChart" height="140"></canvas>
            </div>

            <div class="bg-white rounded-3xl shadow p-6 lg:col-span-2">
                <h2 class="text-2xl font-black text-[#0A2E5D] mb-6">
                    Répartition documentaire
                </h2>

                <canvas id="documentChart" height="90"></canvas>
            </div>

        </div>

        
        <div class="grid lg:grid-cols-2 gap-8 mt-10">

            <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

                <div class="p-6 border-b border-slate-100">
                    <h2 class="text-2xl font-black text-[#0A2E5D]">
                        Top biens les plus demandés
                    </h2>
                </div>

                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-[#0A2E5D]">
                        <tr>
                            <th class="p-5">Bien</th>
                            <th class="p-5">Demandes</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $topRequestedProperties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="border-t border-slate-100">
                                <td class="p-5 font-bold text-[#0A2E5D]">
                                    <?php echo e($property->title); ?>

                                </td>

                                <td class="p-5 text-slate-600">
                                    <?php echo e($property->inquiries_count); ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="2" class="p-8 text-center text-slate-500">
                                    Aucune donnée disponible.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>

            <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

                <div class="p-6 border-b border-slate-100">
                    <h2 class="text-2xl font-black text-[#0A2E5D]">
                        Top villes
                    </h2>
                </div>

                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-[#0A2E5D]">
                        <tr>
                            <th class="p-5">Ville</th>
                            <th class="p-5">Nombre de biens</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $topCities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="border-t border-slate-100">
                                <td class="p-5 font-bold text-[#0A2E5D]">
                                    <?php echo e($city->city); ?>

                                </td>

                                <td class="p-5 text-slate-600">
                                    <?php echo e($city->total); ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="2" class="p-8 text-center text-slate-500">
                                    Aucune donnée disponible.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>

        </div>

    </div>

</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const labels = <?php echo json_encode($chartLabels, 15, 512) ?>;
const monthlyInquiries = <?php echo json_encode($monthlyInquiries, 15, 512) ?>;
const monthlyProperties = <?php echo json_encode($monthlyProperties, 15, 512) ?>;
const transactionStats = <?php echo json_encode($transactionStats, 15, 512) ?>;
const typeStats = <?php echo json_encode($typeStats, 15, 512) ?>;
const documentStats = <?php echo json_encode($documentStats, 15, 512) ?>;

new Chart(document.getElementById('monthlyInquiriesChart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Demandes',
            data: monthlyInquiries,
            tension: 0.35
        }]
    }
});

new Chart(document.getElementById('monthlyPropertiesChart'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Biens ajoutés',
            data: monthlyProperties
        }]
    }
});

new Chart(document.getElementById('transactionChart'), {
    type: 'doughnut',
    data: {
        labels: Object.keys(transactionStats),
        datasets: [{
            data: Object.values(transactionStats)
        }]
    },
    options: {
        maintainAspectRatio: true
    }
});

new Chart(document.getElementById('typeChart'), {
    type: 'bar',
    data: {
        labels: Object.keys(typeStats),
        datasets: [{
            label: 'Nombre de biens',
            data: Object.values(typeStats)
        }]
    }
});

new Chart(document.getElementById('documentChart'), {
    type: 'bar',
    data: {
        labels: Object.keys(documentStats),
        datasets: [{
            label: 'Nombre de biens',
            data: Object.values(documentStats)
        }]
    }
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\sozo-habitat\resources\views/admin/statistics/index.blade.php ENDPATH**/ ?>