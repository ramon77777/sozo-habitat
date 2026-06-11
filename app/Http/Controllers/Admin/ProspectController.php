<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prospect;
use App\Models\User;
use Illuminate\Http\Request;

class ProspectController extends Controller
{
    public function index(Request $request)
    {
        $prospectsQuery = Prospect::with(['property', 'assignedUser'])
            ->latest();

        if ($request->status) {
            $prospectsQuery->where('status', $request->status);
        }

        if ($request->search) {
            $prospectsQuery->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $prospects = $prospectsQuery
            ->paginate(15)
            ->withQueryString();

        $totalProspects = Prospect::count();
        $newProspects = Prospect::where('status', 'nouveau')->count();
        $contactedProspects = Prospect::where('status', 'contacte')->count();
        $visitProspects = Prospect::where('status', 'visite')->count();
        $convertedProspects = Prospect::where('status', 'converti')->count();

        return view('admin.prospects.index', compact(
            'prospects',
            'totalProspects',
            'newProspects',
            'contactedProspects',
            'visitProspects',
            'convertedProspects'
        ));
    }

    public function updateStatus(Request $request, Prospect $prospect)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:nouveau,contacte,visite,negociation,converti,perdu'],
        ]);

        $prospect->update([
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'Statut du prospect mis à jour avec succès.');
    }

    public function assign(Request $request, Prospect $prospect)
    {
        $validated = $request->validate([
            'assigned_to' => ['nullable', 'exists:users,id'],
        ]);

        $prospect->update([
            'assigned_to' => $validated['assigned_to'],
        ]);

        return back()->with('success', 'Prospect assigné avec succès.');
    }
}