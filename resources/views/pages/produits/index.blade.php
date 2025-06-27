{{-- resources/views/produits/edit.blade.php --}}
@extends('layouts.bootstrap')

@section('content')

<div class="container">
    <h2>Liste des Produits</h2><br><br>
    <form method="GET" action="{{ route('pages.produits.index') }}" class="row g-3 mb-4">
        <div class="container">
            <div class="d-flex justify-content-start">
                <!-- Colonne gauche : filtres -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="categorie">Toutes les catégories</label>
                        <select name="categorie_id" class="form-select" value="{{ request('categorie_id') }}">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->id }}">
                                    {{ $categorie->nom }}
                                </option>
                            @endforeach
                        </select>
                        <label for="tri">Trier par</label>
                        <select class="form-control " name="tri" value="{{ request('tri') }}">
                        <option>Prix croissant</option>
                        <option >Prix décroissant</option>
                        </select>
                    </div>

                    <div class="form-group">
                        
                    </div>
                </div>
            </div>
                <button class="btn btn-primary w-10 mb-3">Filtrer</button>
            
        </div>
    </form>
                <a href="{{ route('pages.produits.create') }}" class="btn btn-success w-20 d-flex justify-content-center" style="alignment:right;">Ajouter un produit</a><br><br>
                

                <!-- Colonne droite : liste de produits -->
                <div class="row-md-15">
                <div class="row">
                    @foreach($produits as $produit)
                    <div class="col-md-4 mb-1">
                    <div class="card h-60">
                        <img src="{{ asset('storage/produits/' . $produit->image) }}" class="card-img-top" alt="{{ $produit->nom }}" style="border:border-radius;">
                        <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title">{{ $produit->nom }}</h5>
                            <p class="card-text">Prix : {{ $produit->prix }} F</p>
                            @foreach($categories as $categorie)
                                <p class="card-text">Catégorie : {{ $categorie->nom }}</p>
                            @endforeach
                        </div>
                        <div class="mt-3 d-flex justify-content-between">
                            <a href="{{ route('pages.produits.edit', $produit->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                            
                            <form action="{{ route('pages.produits.destroy', $produit->id) }}" method="POST" onsubmit="return confirm('Supprimer ce produit ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>

                            <a href="{{ route('pages.produits.show', $produit->id) }}" class="btn btn-info btn-sm">Voir</a>
                        </div>
                        </div>
                    </div>
                    </div>
                    @endforeach
                </div>
                </div>
            

        <!-- Pagination -->
        <div class="mt-4">
            {{ $produits->withQueryString()->links() }}
        </div>
    </div>
@endsection