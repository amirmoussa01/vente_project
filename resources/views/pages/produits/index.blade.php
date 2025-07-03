{{-- resources/views/produits/edit.blade.php --}}
@extends('layouts.bootstrap')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
@endif
<div class="container">
    <form method="GET" action="{{ route('pages.produits.index') }}" class="row g-3 mb-4">
        <div class="container">
            <div class="d-flex justify-content-start">
                <!-- Colonne gauche : filtres -->
                <div class="col-md-3 mb-3">
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
                    </div>
                </div>
                <div class="col-md-1 mb-2"></div>
                <div class="col-md-3 mb-3">
                    <div class="form-group">
                        <label for="tri">Trier par</label>
                        <select class="form-select" name="tri">
                            <option value="">-- Sélectionner --</option>
                            <option value="prix_asc" {{ request('tri') == 'prix_asc' ? 'selected' : '' }}>Prix croissant</option>
                            <option value="prix_desc" {{ request('tri') == 'prix_desc' ? 'selected' : '' }}>Prix décroissant</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-1 mb-2"></div>
                <div class="col-md-3 mb-3">
                    <label for="tri"></label><br>
                    <button class="btn btn-primary">Filtrer</button>
                </div>
            </div>
            
        </div>
    </form>
            <a href="{{ route('pages.produits.create') }}" class="btn btn-success w-20 d-flex justify-content-center" style="alignment:right;">Ajouter un produit</a>
            <div class="container py-5">
            <h2 class="mb-4 text-purple">Liste des produits</h2>
            <div class="row">
                @foreach($produits as $produit)
                <div class="col-md-4 mb-4">
                    <div class="card card-purple h-100">
                    @if($produit->image)
                        <img src="{{ asset('storage/produits/' . $produit->image) }}" class="card-img-top" style="padding:30px;padding-bottom:0px;object-fit:cover;" height="175px" alt="{{ $produit->nom }}">
                    @else
                        <img src="https://via.placeholder.com/300x200?text=Image" class="card-img-top" alt="Image par défaut">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $produit->nom }}</h5>
                        <p class="card-text">Prix: {{ $produit->prix }} FCFA</p>
                        <p class="card-text">Catégorie : {{ optional($produit->categorie)->nom ?? 'Non définie' }}</p>
                        <!-- Bouton pour déclencher le modal -->
                        <button type="button" class="btn btn-purple mt-1" data-bs-toggle="modal" data-bs-target="#produitModal{{ $produit->id }}">
                        Voir plus
                        </button>
                        <button type="button" class="btn btn-primary mt-1" data-bs-toggle="modal" data-bs-target="#ajouterProduitModal{{ $produit->id }}">                      
                        Ajouter au panier
                        </button>
                        <!-- Modal voir produit -->
                        <div class="modal fade" id="produitModal{{ $produit->id }}" tabindex="-1" aria-labelledby="produitModalLabel{{ $produit->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="produitModalLabel{{ $produit->id }}">{{ $produit->nom }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                </div>
                                <div class="modal-body">
                                    @if($produit->image)
                                    <img src="{{ asset('storage/produits/' . $produit->image) }}" class="img-fluid mb-2" alt="{{ $produit->nom }}" height="200px">
                                    @endif
                                    <p><strong>Prix :</strong> {{ $produit->prix }} FCFA</p>
                                    <p><strong>Description :</strong><br>{{ $produit->description }}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                </div>
                            </div>
                        </div>
                    </div>


                        <!-- Modal : Ajouter au panier -->
                        <div class="modal fade" id="ajouterProduitModal{{ $produit->id }}" tabindex="-1" aria-labelledby="ajouterProduitModalLabel{{ $produit->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="ajouterProduitModalLabel{{ $produit->id }}">Ajouter au panier</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('pages.paniers.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="produit_id" value="{{ $produit->id }}">
                                            <p>Vous ajoutez le produit : <strong>{{ $produit->nom }}</strong></p>
                                            <div class="mb-3">
                                                <label for="quantite">Quantité</label>
                                                <input type="number" name="quantite" class="form-control" value="1" min="1">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Ajouter</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
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