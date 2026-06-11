@extends('layouts.app')

@section('content')

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

        <div class="grid md:grid-cols-3 gap-6 mb-10">

            <div class="bg-white rounded-3xl p-6 shadow">
                <p class="text-slate-500">Total biens</p>
                <h2 class="text-4xl font-black text-[#0A2E5D] mt-3">
                    {{ $totalProperties }}
                </h2>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow">
                <p class="text-slate-500">Biens vedettes</p>
                <h2 class="text-4xl font-black text-[#C89B3C] mt-3">
                    {{ $featuredProperties }}
                </h2>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow">
                <p class="text-slate-500">Demandes reçues</p>
                <h2 class="text-4xl font-black text-green-600 mt-3">
                    {{ $totalInquiries }}
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

                <canvas id="transactionChart" height="140"></canvas>
            </div>

            <div class="bg-white rounded-3xl shadow p-6">
                <h2 class="text-2xl font-black text-[#0A2E5D] mb-6">
                    Types de biens
                </h2>

                <canvas id="typeChart" height="140"></canvas>
            </div>

        </div>

        <div class="mt-10 bg-white rounded-3xl shadow-xl overflow-hidden">

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
                    @forelse($topCities as $city)
                        <tr class="border-t border-slate-100">
                            <td class="p-5 font-bold text-[#0A2E5D]">
                                {{ $city->city }}
                            </td>

                            <td class="p-5 text-slate-600">
                                {{ $city->total }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="p-8 text-center text-slate-500">
                                Aucune donnée disponible.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

    </div>

</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const labels = @json($chartLabels);
const monthlyInquiries = @json($monthlyInquiries);
const monthlyProperties = @json($monthlyProperties);
const transactionStats = @json($transactionStats);
const typeStats = @json($typeStats);

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
</script>

@endsection