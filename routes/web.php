<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
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
