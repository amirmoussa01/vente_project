@extends('layout')

@section('title', 'Validation de la commande')

@section('content')
    <h2>Valider votre commande</h2>

    <form action="{{ route('commandes.store') }}" method="POST">
        @csrf

        <h3>Adresse de livraison</h3>
        <label>Nom :
            <input type="text" name="nom" required>
        </label><br>

        <label>Adresse :
            <input type="text" name="adresse" required>
        </label><br>

        <label>Ville :
            <input type="text" name="ville" required>
        </label><br>

        <label>Code postal :
            <input type="text" name="code_postal" required>
        </label><br>

        <h3>Récapitulatif</h3>
        <ul>
            @foreach($panier as $item)
                <li>
                    {{ $item['produit']->nom }} — 
                    {{ $item['quantite'] }} x {{ number_format($item['produit']->prix, 2) }} €
                </li>
            @endforeach
        </ul>

        <p><strong>Total : {{ number_format($total, 2) }} €</strong></p>

        <button type="submit">Confirmer la commande</button>
    </form>
@endsection
