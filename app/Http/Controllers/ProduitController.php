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

        // Filtrer par nom (recherche globale)
        if ($request->filled('search')) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }

        // Filtrer par catégorie
        if ($request->filled('categorie_id')) {
            $query->where('categorie_id', $request->categorie_id);
        }

        // Tri
        if ($request->filled('tri')) {
            if ($request->tri == 'prix_asc') {
                $query->orderBy('prix', 'asc');
            } elseif ($request->tri == 'prix_desc') {
                $query->orderBy('prix', 'desc');
            }
        }

        $produits = $query->paginate(10);
        $categories = Categorie::all();

        return view('pages.produits.index', compact('produits', 'categories'));
    }


    public function create()
    {
        $categories = Categorie::all();
        return view('pages.produits.create', compact('categories'));
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

        return redirect()->route('pages.produits.index')->with('success', 'Produit ajouté.');
    }

    public function edit(Produit $produit)
    {
        $categories = Categorie::all();
        return view('pages.produits.edit', compact('produit', 'categories'));
    }

    public function update(Request $request, Produit $produit)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'image' => 'nullable|image',
            'categorie_id' => 'required|exists:categories,id'
        ]);

        $data = [
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
            'stock' => $request->stock,
            'categorie_id' => $request->categorie_id,
        ];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('produits', 'public');
            $data['image'] = basename($path);
        }

        $produit->update($data);

        return redirect()->route('pages.produits.index')->with('success', 'Produit modifié.');
    }

    public function destroy(Produit $produit)
    {
        $produit->delete();
        return redirect()->route('pages.produits.index')->with('success', 'Produit supprimé.');
    }

    public function show(Produit $produit)
    {
        return view('pages.produits.show', compact('produit'));
    }
}
