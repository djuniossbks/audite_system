<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $utilisateurs = User::latest()->paginate(10);

        return view('utilisateurs.index', compact('utilisateurs'));
    }

    public function create(): View
    {
        return view('utilisateurs.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['admin', 'utilisateur'])],
        ]);

        // Le cast "hashed" du modèle User chiffre le mot de passe automatiquement.
        $utilisateur = User::create($data);
        AuditLogger::log("Ajout de l'utilisateur {$utilisateur->name}", 'users', $utilisateur->id);

        return redirect()->route('utilisateurs.index')->with('success', 'Utilisateur ajouté.');
    }

    public function edit(User $utilisateur): View
    {
        return view('utilisateurs.edit', compact('utilisateur'));
    }

    public function update(Request $request, User $utilisateur): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($utilisateur->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['admin', 'utilisateur'])],
        ]);

        if (blank($data['password'])) {
            unset($data['password']);
        }

        $utilisateur->update($data);
        AuditLogger::log("Modification de l'utilisateur {$utilisateur->name}", 'users', $utilisateur->id);

        return redirect()->route('utilisateurs.index')->with('success', 'Utilisateur modifié.');
    }

    public function destroy(User $utilisateur): RedirectResponse
    {
        if (auth()->id() === $utilisateur->id) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $nom = $utilisateur->name;
        $id = $utilisateur->id;
        $utilisateur->delete();

        AuditLogger::log("Suppression de l'utilisateur {$nom}", 'users', $id);

        return redirect()->route('utilisateurs.index')->with('success', 'Utilisateur supprimé.');
    }
}
