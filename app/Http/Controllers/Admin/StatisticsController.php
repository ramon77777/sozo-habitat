<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyInquiry;

class StatisticsController extends Controller
{
    public function index()
    {
        $chartLabels = [];
        $monthlyInquiries = [];
        $monthlyProperties = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);

            $chartLabels[] = ucfirst($date->translatedFormat('M Y'));

            $monthlyInquiries[] = PropertyInquiry::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $monthlyProperties[] = Property::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        $totalProperties = Property::count();
        $featuredProperties = Property::where('featured', true)->count();

        $totalInquiries = PropertyInquiry::count();
        $processedInquiries = PropertyInquiry::where('is_processed', true)->count();
        $pendingInquiries = PropertyInquiry::where('is_processed', false)->count();

        $processingRate = $totalInquiries > 0
            ? round(($processedInquiries / $totalInquiries) * 100)
            : 0;

        $transactionStats = [
            'Ventes' => Property::where('transaction', 'vente')->count(),
            'Locations' => Property::where('transaction', 'location')->count(),
        ];

        $typeStats = [
            'Villa' => Property::where('type', 'villa')->count(),
            'Duplex' => Property::where('type', 'duplex')->count(),
            'Appartement' => Property::where('type', 'appartement')->count(),
            'Maison basse' => Property::where('type', 'maison_basse')->count(),
            'Terrain' => Property::where('type', 'terrain')->count(),
        ];

        $documentStats = [
            'ACD disponible' => Property::where('has_acd', true)->count(),
            'Lot approuvé' => Property::where('is_lot_approved', true)->count(),
            'Sans document' => Property::where('has_acd', false)
                ->where('is_lot_approved', false)
                ->whereNull('document_type')
                ->count(),
        ];

        $topCities = Property::select('city')
            ->selectRaw('COUNT(*) as total')
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->groupBy('city')
            ->orderByDesc('total')
            ->take(10)
            ->get();

        $topRequestedProperties = Property::withCount('inquiries')
            ->orderByDesc('inquiries_count')
            ->take(10)
            ->get();

        return view('admin.statistics.index', compact(
            'chartLabels',
            'monthlyInquiries',
            'monthlyProperties',
            'totalProperties',
            'featuredProperties',
            'totalInquiries',
            'processedInquiries',
            'pendingInquiries',
            'processingRate',
            'transactionStats',
            'typeStats',
            'documentStats',
            'topCities',
            'topRequestedProperties'
        ));
    }
}