<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:12', 'confirmed'],
            'role' => ['required', Rule::in(['admin', 'agent'])],
        ]);

        User::create($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Utilisateur créé avec succès.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => ['nullable', 'string', 'min:12', 'confirmed'],
            'role' => ['required', Rule::in(['admin', 'agent'])],
        ]);

        if (
            $user->role === 'admin'
            && $validated['role'] !== 'admin'
            && User::where('role', 'admin')->count() <= 1
        ) {
            return back()
                ->withInput()
                ->with('error', 'Le dernier administrateur ne peut pas être transformé en agent.');
        }

        if (auth()->id() === $user->id && $validated['role'] !== $user->role) {
            return back()
                ->withInput()
                ->with('error', 'Vous ne pouvez pas modifier votre propre rôle.');
        }

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Utilisateur modifié avec succès.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with(
                'error',
                'Vous ne pouvez pas supprimer votre propre compte.'
            );
        }

        if (
            $user->role === 'admin'
            && User::where('role', 'admin')->count() <= 1
        ) {
            return back()->with(
                'error',
                'Le dernier compte administrateur ne peut pas être supprimé.'
            );
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }
}
