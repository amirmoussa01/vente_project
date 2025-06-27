@extends('layout.bootstrap')

@section('title', 'Modifier une commande')

@section('content')
    <h2>Modifier la commande #{{ $commande->id }}</h2>

    <form action="{{ route('commandes.update', $commande->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="statut">Statut de la commande :</label>
            <select name="statut" id="statut" required>
                <option value="en attente" {{ $commande->statut === 'en attente' ? 'selected' : '' }}>En attente</option>
                <option value="en cours" {{ $commande->statut === 'en cours' ? 'selected' : '' }}>En cours</option>
                <option value="expédiée" {{ $commande->statut === 'expédiée' ? 'selected' : '' }}>Expédiée</option>
                <option value="livrée" {{ $commande->statut === 'livrée' ? 'selected' : '' }}>Livrée</option>
                <option value="annulée" {{ $commande->statut === 'annulée' ? 'selected' : '' }}>Annulée</option>
            </select>
        </div>

        <h4>Produits de la commande :</h4>
        <ul>
            @foreach($commande->produits as $produit)
                <li>
                    {{ $produit->nom }} —
                    Quantité : {{ $produit->pivot->quantite }}
                </li>
            @endforeach
        </ul>

        <br>
        <button type="submit">Enregistrer les modifications</button>
    </form>

    <br>
    <a href="{{ route('commandes.index') }}">← Retour à la liste des commandes</a>
@endsection
