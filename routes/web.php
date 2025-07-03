<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaiementController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Routes pour les paniers
    Route::get('/panier', [PanierController::class, 'mespaniers'])->name('pages.paniers.index');
    Route::post('/paniers/ajouter-produit', [PanierController::class, 'ajouterProduit'])->name('pages.paniers.store');;
    Route::put('/paniers/update-produit-panier/{id}', [PanierController::class, 'updateProduitPanier'])->name('pages.paniers.update');;
    Route::delete('/paniers/supprimer-produit/{id}', [PanierController::class, 'supprimerProduit'])->name('pages.paniers.destroy');;
    Route::delete('/paniers/vider-panier/{id}', [PanierController::class, 'viderPanier'])->name('pages.paniers.delete');;

    // Routes pour les commandes
    Route::get('/mes-commandes', [CommandeController::class, 'mescommandes'])->name('pages.commandes.index');
    Route::post('/commandes', [CommandeController::class, 'store'])->name('pages.commandes.store');
    Route::post('/commandes/annuler-commande/{id}', [CommandeController::class, 'annulerCommande'])->name('pages.commandes.delete');

    Route::get('/mes-paiements', [PaiementController::class, 'index'])->name('paiements.index');
    Route::post('/paiement', [PaiementController::class, 'store'])->name('paiements.store');
    Route::get('/recu/{id}', [PaiementController::class, 'telechargerRecu'])->name('paiements.recu');
});

require __DIR__.'/auth.php';

    Route::get('/paniers', [PanierController::class, 'index']);

    Route::get('/commandes', [CommandeController::class, 'index']);






    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/produits', [AdminController::class, 'produits'])->name('admin.produits');


Route::resource('categories', CategorieController::class);
Route::get('/creer', function () {
    return view('pages.produits.create');
});
// Produits
Route::get('/produits', [ProduitController::class, 'index'])->name('pages.produits.index');
Route::get('/produits/create', [ProduitController::class, 'create'])->name('pages.produits.create');
Route::post('/produits', [ProduitController::class, 'store'])->name('pages.produits.store');
Route::get('/produits/{id}', [ProduitController::class, 'show'])->name('pages.produits.show');
Route::get('/produits/{produit}/edit', [ProduitController::class, 'edit'])->name('pages.produits.edit');
Route::put('/produits/{produit}', [ProduitController::class, 'update'])->name('pages.produits.update');
Route::delete('/produits/{produit}', [ProduitController::class, 'destroy'])->name('pages.produits.destroy');

// Categories
Route::get('/categories', [CategorieController::class, 'index'])->name('pages.categories.index');
Route::get('/categories/create', [CategorieController::class, 'create'])->name('pages.categories.create');
Route::post('/categories', [CategorieController::class, 'store'])->name('pages.categories.store');
Route::get('/categories/{id}', [CategorieController::class, 'show'])->name('pages.categories.show');
Route::get('/categories/{id}/edit', [CategorieController::class, 'edit'])->name('pages.categories.edit');
Route::put('/categories/{id}', [CategorieController::class, 'update'])->name('pages.categories.update');
Route::delete('/categories/{id}', [CategorieController::class, 'destroy'])->name('pages.categories.destroy');

