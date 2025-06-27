@extends('layout')

@section('title', 'Commande validée')

@section('content')
    <h2>Merci pour votre commande !</h2>

    <p>Votre commande a été enregistrée avec succès.</p>
    <p>Numéro de commande : <strong>#{{ $commande->id }}</strong></p>

    <a href="{{ route('produits.index') }}">Retour à la boutique</a>
@endsection
