<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paiement extends Model
{
    protected $fillable = [
        'commande_id',
        'montant',
        'statut',
        'date_paiement',
        'transaction_id',
    ];
    protected $casts = [
        'date_paiement' => 'datetime',
    ];

    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class);
    }
}
