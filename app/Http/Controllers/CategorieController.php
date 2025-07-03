<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Http\Request;
use App\Http\Controllers\ProduitController;

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

    public function edit($id)
    {
        $categorie = Categorie::find($id);
        return view('pages.categories.edit', compact('categorie'));
    }

    public function update(Request $request, $id)
    {   
        $categorie= Categorie::find($id);
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $categorie->nom = $request->input('nom');
        $categorie->description = $request->input('description');
        $categorie->save();

        return redirect()->route('pages.categories.index')->with('success', 'Catégorie mise à jour.');
    }

    public function destroy($id)
    {
        $categorie= Categorie::find($id);
        $produits = Produit::where('categorie_id', $id)->count();
        if($produits >0){
           return redirect()->route('pages.categories.index')->with('error', 'Impossible de supprimer cette categorie car des produits y son associés !!');
        }else{
            $categorie->delete();
            return redirect()->route('pages.categories.index')->with('success', 'Catégorie supprimée.');
        }
        
    }
}
