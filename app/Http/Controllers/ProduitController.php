<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Http\Request;


class ProduitController extends Controller
{
    public function index(Request $request)
    {
        $query = Produit::query();

        // Filtrage par catégorie
        if ($request->filled('categorie_id')) {
            $query->where('categorie_id', $request->categorie_id);
        }

        // Recherche par nom
        if ($request->filled('q')) {
            $query->where('nom', 'like', '%' . $request->q . '%');
        }

        // Tri par prix
        if ($request->filled('sort') && in_array($request->sort, ['asc', 'desc'])) {
            $query->orderBy('prix', $request->sort);
        }

        $produits = $query->paginate(10);
        $categories = Categorie::all();

        return view('produits.index', compact('produits', 'categories'));
    }

    public function create()
    {
        $categories = Categorie::all();
        return view('produits.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'image' => 'nullable|image',
            'categorie_id' => 'required|exists:categories,id'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $Path = $request->file('image')->store('produits', 'public');
            $imagePath=basename($Path);
        }

        Produit::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
            'stock' => $request->stock,
            'image' => $imagePath,
            'categorie_id' => $request->categorie_id
        ]);

        return redirect()->route('produits.index')->with('success', 'Produit ajouté.');
    }

    public function edit(Produit $produit)
    {
        $categories = Categorie::all();
        return view('produits.edit', compact('produit', 'categories'));
    }

    public function update(Request $request, Produit 

$produit)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'image' => 'nullable|image',
            'categorie_id' => 'required|exists:categories,id'
        ]);

        if ($request->hasFile('image')) {
            $Path = $request->file('image')->store('produits', 'public');
            $imagePath=basename($Path);
            $produit->image = $imagePath;
        }

        $produit->update([
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
            'stock' => $request->stock,
            'categorie_id' => $request->categorie_id,
            'image' => $produit->image
        ]);

        return redirect()->route('produits.index')->with('success', 'Produit modifié.');
    }

    public function destroy(Produit $produit)
    {
        $produit->delete();
        return redirect()->route('produits.index')->with('success', 'Produit supprimé.');
    }

    public function show(Produit $produit)
    {
        return view('produits.show', compact('produit'));
    }
}
