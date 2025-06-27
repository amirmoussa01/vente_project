<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function paniers()
    {
        return $this->belongsToMany(Panier::class, 'produits_panier')->withPivot('quantite')->withTimestamps();
    }
    
      public function commandes()
    {
        return $this->belongsToMany(Commande::class, 'produits_commande')
                    ->withPivot('quantite')
                    ->withTimestamps();
    }

}
