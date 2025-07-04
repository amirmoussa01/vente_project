<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\AdminController;

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
    
    Route::post('/commandes', [CommandeController::class, 'store'])->name('commandes.store');
    Route::get('/commandes', [CommandeController::class, 'index'])->name('commandes.index');
    Route::get('/commandes/create', [CommandeController::class, 'create'])->name('commandes.create');

    Route::get('/commandes/success/{commande}', [CommandeController::class, 'success'])->name('commandes.success');

    Route::get('/commandes/{commande}/edit', [CommandeController::class, 'edit'])->name('commandes.edit');
    Route::put('/commandes/{commande}', [CommandeController::class, 'update'])->name('commandes.update');
});

require __DIR__.'/auth.php';



Route::middleware(['auth'])->group(function () {
    Route::get('/panier', [PanierController::class, 'index'])->name('panier.index');
    Route::post('/panier/ajouter/{id}', [PanierController::class, 'ajouter'])->name('panier.ajouter');
    Route::post('/panier/modifier/{id}', [PanierController::class, 'modifier'])->name('panier.modifier');
    Route::post('/panier/supprimer/{id}', [PanierController::class, 'supprimer'])->name('panier.supprimer');
    Route::post('/panier/vider', [PanierController::class, 'vider'])->name('panier.vider');
});
// Route::get('/admin/login', [AdminController::class, 'loginForm'])->name('admin.login');
// Route::post('/admin/login', [AdminController::class, 'login']);
// Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Routes admin

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
Route::get('/categories/{categorie}/edit', [CategorieController::class, 'edit'])->name('pages.categories.edit');
Route::put('/categories/{id}', [CategorieController::class, 'update'])->name('pages.categories.update');
Route::delete('/categories/{id}', [CategorieController::class, 'destroy'])->name('pages.categories.destroy');

