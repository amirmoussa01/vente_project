<?php

namespace App\Http\Controllers;

use App\Models\ProduitCommande;
use App\Models\Panier;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Nombre total de produits achetés par l'utilisateur
       $produitsAchatCount = DB::table('produits_commande')
            ->join('commandes', 'produits_commande.commande_id', '=', 'commandes.id')
            ->where('commandes.user_id', $userId)
            ->where('commandes.statut', '!=', 'annulée')
            ->sum('produits_commande.quantite');

        // Nombre total de paniers commandés (commandes liées à panier)
        $paniersCommandesCount = Commande::where('user_id', $userId)
            ->where('statut', '!=', 'annulée')
            ->count();

        // Nombre de commandes en cours
        $commandesEnCoursCount = Commande::where('user_id', $userId)
            ->where('statut', 'en cours')
            ->count();

        // Statistiques d'achat par mois pour l'année en cours
        $statsParMois = ProduitCommande::select(
                DB::raw("MONTH(commandes.created_at) as mois"),
                DB::raw("SUM(produits_commande.quantite) as total_produits")
            )
            ->join('commandes', 'produits_commande.commande_id', '=', 'commandes.id')
            ->where('commandes.user_id', $userId)
            ->whereYear('commandes.created_at', Carbon::now()->year)
            ->groupBy(DB::raw("MONTH(commandes.created_at)"))
            ->orderBy(DB::raw("MONTH(commandes.created_at)"))
            ->get();

        // Initialiser un tableau 12 mois avec 0
        $statsMoisComplets = array_fill(1, 12, 0);

        // Remplir avec les valeurs récupérées
        foreach ($statsParMois as $stat) {
            $statsMoisComplets[(int)$stat->mois] = (int)$stat->total_produits;
        }

        return view('pages.dashboard', compact(
            'produitsAchatCount',
            'paniersCommandesCount',
            'commandesEnCoursCount',
            'statsMoisComplets'
        ));
    }
}