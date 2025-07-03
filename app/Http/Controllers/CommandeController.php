<?php

namespace App\Http\Controllers;

use App\Models\Panier;
use App\Models\Produit;
use App\Models\Commande;
use Illuminate\Http\Request;
use App\Models\ProduitPanier;
use App\Models\ProduitCommande;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommandeController extends Controller
{
    public function index()
    {
        $commandes = Commande::with('produits')->get();
        return view('pages.commandes.index', compact('commandes'));
    }

    public function mescommandes()
    {
        $userId = Auth::user()->id;
        $commandes = Commande::where('user_id', $userId)->get();

        $fedapayPublicKey = config('services.fedapay.public_key');

        return view('pages.commandes.index', compact('commandes', 'fedapayPublicKey'));
    }

    public function store(Request $request)
    {
        $userId = Auth::user()->id;
        $panier = Panier::where('user_id', $userId)->first();
        if (!$panier) {
            return redirect()->back()->with('error', 'Vous n\'avez pas de panier');
        }

        $produitsPanier = ProduitPanier::where('panier_id', $panier->id)->get();
        $total = 0;
        foreach ($produitsPanier as $produitPanier) {
            $produit = Produit::find($produitPanier->produit_id);
            if ($produit->stock < $produitPanier->quantite) {
                return redirect()->back()->with('error', 'Le produit ' . $produit->nom . ' n\'est pas disponible en stock');
            }
            $total += $produit->prix * $produitPanier->quantite;
        }

        $commande = new Commande();
        $commande->user_id = $userId;
        $commande->statut = 'en cours';
        $commande->total = $total;
        $commande->save();

        foreach ($produitsPanier as $produitPanier) {
            $produit = Produit::find($produitPanier->produit_id);
            $produitCommande = new ProduitCommande();
            $produitCommande->commande_id = $commande->id;
            $produitCommande->produit_id = $produitPanier->produit_id;

            $produitCommande->quantite = $produitPanier->quantite;
            $produitCommande->save();
            $produit->stock -= $produitPanier->quantite;
            $produit->save();
        }

        foreach ($produitsPanier as $produitPanier) {
            $produitPanier->delete();
        }

        return redirect()->route('pages.commandes.index')->with('success', 'La commande a été créée');
    }

    public function annulerCommande($id)
    {
        $commande = Commande::find($id);
        if ($commande->user_id != Auth::user()->id) {
            return redirect()->back()->with('error', 'Vous n\'avez pas le droit d\'annuler cette commande');
        }
        $produitsCommande = ProduitCommande::where('commande_id', $commande->id)->get();
        foreach ($produitsCommande as $produitCommande) {
            $produit = Produit::find($produitCommande->produit_id);
            $produit->stock += $produitCommande->quantite;
            $produit->save();
        }
        $commande->statut = 'annulée';
        $commande->save();
        return redirect()->route('pages.commandes.index')->with('success', 'La commande a été annulée');
    }
}


