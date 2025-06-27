@extends('layouts.bootstrap')

@section('content')
<div class="container">
    <h2 class="mb-4">Mon Panier</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($panier && $panier->produits->count() > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($panier->produits as $produit)
                <tr>
                    <td>
                        @if($produit->image)
                            <img src="{{ asset('storage/' . $produit->image) }}" width="80" height="80">
                        @else
                            <span>Aucune image</span>
                        @endif
                    </td>
                    <td>{{ $produit->nom }}</td>
                    <td>{{ number_format($produit->prix, 2) }} €</td>
                    <td>
                        <form action="{{ route('panier.modifier', $produit->id) }}" method="POST" class="d-flex">
                            @csrf
                            <input type="number" name="quantite" value="{{ $produit->pivot->quantite }}" min="1" class="form-control me-2" style="width: 80px;">
                            <button type="submit" class="btn btn-sm btn-primary">Modifier</button>
                        </form>
                    </td>
                    <td>{{ number_format($produit->prix * $produit->pivot->quantite, 2) }} €</td>
                    <td>
                        <form action="{{ route('panier.supprimer', $produit->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between">
            <h4>
                Total : 
                {{ number_format($panier->produits->sum(fn($p) => $p->prix * $p->pivot->quantite), 2) }} €
            </h4>
            <form action="{{ route('panier.vider') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-warning">Vider le panier</button>
            </form>
        </div>

    @else
        <p>Votre panier est vide.</p>
    @endif
</div>
@endsection
