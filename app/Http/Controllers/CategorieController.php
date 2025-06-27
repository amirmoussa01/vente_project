<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::all();
        return view('pages.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('pages.categories.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable'
        ]);

        Categorie::create([
            'nom' => $request->nom,
            'description' => $request->description
        ]);

        return redirect()->route('pages.categories.index')->with('success', 'Catégorie ajoutée avec succès.');
    }

    public function edit(Categorie $categories)
    {
        return view('pages.categories.edit', compact('categorie'));
    }

    public function update(Request $request, Categorie $categories)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable'
        ]);

        $categories->update([
            'nom' => $request->nom,
            'description' => $request->description
        ]);

        return redirect()->route('pages.categories.index')->with('success', 'Catégorie modifiée avec succès.');
    }

    public function destroy(Categorie $categories)
    {
        $categories->delete();
        return redirect()->route('pages.categories.index')->with('success', 'Catégorie supprimée.');
    }
}
