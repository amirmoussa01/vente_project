<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    public function passerCommande(Request $request)
    {
        $request->validate([
            'produits' => 'required|array',
            'produits.*.id' => 'required|exists:produits,id',
            'produits.*.quantite' => 'required|integer|min:1'
        ]);

        $total = 0;

        DB::beginTransaction();

        try {
            foreach ($request->produits as $item) {
                $produit = Produit::findOrFail($item['id']);

                if ($produit->stock < $item['quantite']) {
                    throw new \Exception("Stock insuffisant pour le produit: {$produit->nom}");
                }

                $total += $produit->prix * $item['quantite'];
            }

            $commande = Commande::create([
                'user_id' => Auth::id(),
                'statut' => 'en attente',
                'total' => $total
            ]);

            foreach ($request->produits as $item) {
                $commande->produits()->attach($item['id'], [
                    'quantite' => $item['quantite']
                ]);

                // Mettre à jour le stock
                $produit = Produit::findOrFail($item['id']);
                $produit->decrement('stock', $item['quantite']);
            }

            DB::commit();

            return response()->json(['message' => 'Commande passée avec succès !', 'commande_id' => $commande->id], 201);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function edit(Commande $commande)
{
    return view('commandes.edit', compact('commande'));
}

public function update(Request $request, Commande $commande)
{
    $request->validate([
        'statut' => 'required|string|in:en attente,en cours,expédiée,livrée,annulée',
    ]);

    $commande->update(['statut' => $request->statut]);

    return redirect()->route('commandes.index')->with('success', 'Commande mise à jour.');
}

}
