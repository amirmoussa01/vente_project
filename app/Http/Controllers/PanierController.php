<?php

namespace App\Http\Controllers;

use App\Models\Panier;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanierController extends Controller
{
    // Voir panier
    public function index()
    {
        $panier = Panier::where('user_id', Auth::id())->latest()->first();
        return view('panier.index', compact('panier'));
    }

    // Ajouter produit
    public function ajouter(Request $request, $produit_id)
    {
        $user = Auth::user();
        $produit = Produit::findOrFail($produit_id);

        // Créer panier si inexistant
        $panier = Panier::firstOrCreate(
            ['user_id' => $user->id],
            ['date_creation' => now()]
        );

        // Ajouter ou mettre à jour le produit dans le panier
        $existing = $panier->produits()->where('produit_id', $produit_id)->first();

        if ($existing) {
            $panier->produits()->updateExistingPivot($produit_id, [
                'quantite' => $existing->pivot->quantite + 1
            ]);
        } else {
            $panier->produits()->attach($produit_id, ['quantite' => 1]);
        }

        return redirect()->back()->with('success', 'Produit ajouté au panier');
    }

    // Modifier quantité
    public function modifier(Request $request, $produit_id)
    {
        $quantite = $request->input('quantite');

        $panier = Panier::where('user_id', Auth::id())->latest()->first();

        if ($panier) {
            $panier->produits()->updateExistingPivot($produit_id, ['quantite' => $quantite]);
        }

        return redirect()->back()->with('success', 'Quantité mise à jour.');
    }

    // Supprimer un produit
    public function supprimer($produit_id)
    {
        $panier = Panier::where('user_id', Auth::id())->latest()->first();
        if ($panier) {
            $panier->produits()->detach($produit_id);
        }

        return redirect()->back()->with('success', 'Produit supprimé.');
    }

    // Vider le panier
    public function vider()
    {
        $panier = Panier::where('user_id', Auth::id())->latest()->first();
        if ($panier) {
            $panier->produits()->detach();
        }

        return redirect()->back()->with('success', 'Panier vidé.');
    }
}
