<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commande extends Model
{
    protected $fillable = [
        'user_id',
        'statut',
        'total',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function produits(): HasMany
    {

        return $this->hasMany(ProduitCommande::class);
    }
}

