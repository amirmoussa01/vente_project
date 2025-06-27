@extends('layout.bootstrap')

@section('title', 'Mes commandes')

@section('content')
    <h2>Historique des commandes</h2>

    @forelse($commandes as $commande)
        <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
            <p><strong>Commande #{{ $commande->id }}</strong></p>
            <p>Statut : {{ $commande->statut }}</p>
            <p>Total : {{ number_format($commande->total, 2) }} €</p>
            <ul>
                @foreach($commande->produits as $produit)
                    <li>
                        {{ $produit->nom }} — {{ $produit->pivot->quantite }} x {{ number_format($produit->prix, 2) }} €
                    </li>
                @endforeach
            </ul>
        </div>
    @empty
        <p>Aucune commande pour le moment.</p>
    @endforelse
@endsection
