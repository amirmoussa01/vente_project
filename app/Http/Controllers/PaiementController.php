<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Commande;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;

class PaiementController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;

        $paiements = Paiement::whereHas('commande', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->with('commande.produits')->get();

        return view('pages.paiements.index', compact('paiements'));
    }

    public function store(Request $request)
    {
        $commande = Commande::findOrFail($request->commande_id);

        Paiement::create([
            'commande_id' => $commande->id,
            'montant' => $commande->total,
            'statut' => 'encours',
            'date_paiement' => Carbon::now(),
            'transaction_id' => null,
        ]);

        return response()->json(['success' => true]);
    }

    public function telechargerRecu($id)
    {
        $paiement = Paiement::with('commande.produits')->findOrFail($id);

        if ($paiement->commande->user_id !== auth()->user()->id) {
            abort(403);
        }

        $pdf = PDF::loadView('pages.paiements.recu', compact('paiement'));
        return $pdf->download('recu_paiement_' . $paiement->id . '.pdf');
    }
}
