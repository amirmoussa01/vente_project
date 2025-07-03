<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produit extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'prix',
        'image',
        'stock',
        'categorie_id',
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

        public function produitsPaniers(): HasMany
    {
        return $this->hasMany(ProduitPanier::class);
    }

    public function produitsCommandes(): HasMany
    {
        return $this->hasMany(ProduitCommande::class);
    }


}
