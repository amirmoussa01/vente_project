<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Panier;
use App\Models\ProduitPanier;
use App\Models\Produit;

class PanierController extends Controller
{
    public function index()
    {
        $paniers = Panier::with('produits')->get();
        return view('pages.paniers.index', compact('paniers'));
    }

    public function mespaniers()
    {
        $userId = auth()->user()->id;
        $panier = Panier::where('user_id', $userId)->first();
        if (!$panier) {
            return redirect()->back()->with('error', 'Vous n\'avez pas de panier');
        }
        $produitsPanier = ProduitPanier::where('panier_id', $panier->id)->get();
        return view('pages.paniers.index', compact('panier'));
    }

    public function ajouterProduit(Request $request)
    {
        $produit = Produit::find($request->input('produit_id'));
        if ($produit->stock < $request->input('quantite')) {
            return redirect()->back()->with('error', 'Le produit n\'est pas disponible en stock');
        }

        $userId = auth()->user()->id;
        $quantite = $request->input('quantite');
        $panier = Panier::where('user_id', $userId)->first();
        if (!$panier) {
            $panier = new Panier();
            $panier->user_id = $userId;
            $panier->quantite = $quantite;
            $panier->save();
        }

        $produitPanier = ProduitPanier::where('panier_id', $panier->id)
            ->where('produit_id', $produit->id)
            ->first();

        if ($produitPanier) {
            $produitPanier->quantite += $request->input('quantite');
            $produitPanier->save();
        } else {
            $produitPanier = new ProduitPanier();
            $produitPanier->panier_id = $panier->id;
            $produitPanier->produit_id = $produit->id;

            $produitPanier->quantite = $request->input('quantite');
            $produitPanier->save();
        }

        return redirect()->route('pages.paniers.index')->with('success', 'Le produit a été ajouté au panier');
    }

    public function updateProduitPanier(Request $request, $id)
    {
        $produitPanier = ProduitPanier::find($id);
        $produit = Produit::find($produitPanier->produit_id);
        if ($produit->stock < $request->input('quantite')) {
            return redirect()->back()->with('error', 'Le produit n\'est pas disponible en stock');
        }

        $produitPanier->quantite = $request->input('quantite');
        $produitPanier->save();

        return redirect()->route('pages.paniers.index')->with('success', 'La quantité du produit a été mise à jour');
    }

    public function supprimerProduit($id)
    {
        $produitPanier = ProduitPanier::find($id);
        $produitPanier->delete();
        return redirect()->route('pages.paniers.index')->with('success', 'Le produit a été supprimé du panier');
    }

    public function viderPanier($id)
    {
        $produitsPanier = ProduitPanier::where('panier_id', $id)->get();
        foreach ($produitsPanier as $produitPanier) {
            $produitPanier->delete();
        }
        return redirect()->route('pages.paniers.index')->with('success', 'Le panier a été vidé');
    }
}
