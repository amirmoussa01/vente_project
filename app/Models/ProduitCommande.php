<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProduitCommande extends Pivot
{
    protected $table = 'produits_commande';

    protected $fillable = ['commande_id', 'produit_id', 'quantite'];
}