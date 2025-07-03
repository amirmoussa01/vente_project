<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, "Accès refusé. Vous n'êtes pas administrateur.");
        }

        return view('admin.dashboard');
    }

    // Exemple de gestion produit
    public function produits()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        return view('admin.produits.index');
    }
}

