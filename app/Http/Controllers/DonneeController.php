<?php

namespace App\Http\Controllers;

use App\Models\Donnee;
use App\Services\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DonneeController extends Controller
{
    public function index(): View
    {
        $donnees = Donnee::with('utilisateur')->latest()->paginate(10);

        return view('donnees.index', compact('donnees'));
    }

    public function create(): View
    {
        return view('donnees.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        $data['utilisateur_id'] = $request->user()->id;
        $donnee = Donnee::create($data);

        AuditLogger::log("Ajout de la donnée #{$donnee->id}", 'donnees', $donnee->id);

        return redirect()->route('donnees.index')->with('success', 'Donnée ajoutée.');
    }

    public function show(Donnee $donnee): View
    {
        AuditLogger::log("Consultation de la donnée #{$donnee->id}", 'donnees', $donnee->id);

        return view('donnees.show', compact('donnee'));
    }

    public function edit(Donnee $donnee): View
    {
        return view('donnees.edit', compact('donnee'));
    }

    public function update(Request $request, Donnee $donnee): RedirectResponse
    {
        $data = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        $donnee->update($data);
        AuditLogger::log("Modification de la donnée #{$donnee->id}", 'donnees', $donnee->id);

        return redirect()->route('donnees.index')->with('success', 'Donnée modifiée.');
    }

    public function destroy(Donnee $donnee): RedirectResponse
    {
        $id = $donnee->id;
        $donnee->delete();
        AuditLogger::log("Suppression de la donnée #{$id}", 'donnees', $id);

        return redirect()->route('donnees.index')->with('success', 'Donnée supprimée.');
    }
}
