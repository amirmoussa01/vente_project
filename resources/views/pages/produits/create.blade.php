{{-- resources/views/pages/produits/create.blade.php --}}
@extends('layouts.bootstrap')

@section('content')

<div class="col-md-6 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h2 class="card-title">Ajouter un produit</h2>
        <form class="forms-sample" action="{{ route('pages.produits.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="form-group">
            <label for="nom">Nom du Produit</label>
            <input type="text" class="form-control" name="nom" id="nom" placeholder="Entrer un nom...">
            </div>
            <div class="form-group">
            <label for="prix">Prix du Produit</label>
            <input type="text" class="form-control" name="prix" id="prix" placeholder="Entrer un prix...">
            </div>
            <div class="form-group">
            <label for="stock">Stock du Produit</label>
            <input type="text" class="form-control" name="stock" id="stock" placeholder="Entrer un quantité...">
            </div>
            <div class="form-group">
            <label for="categorie_id">Catégorie du produit</label>
            <select name="categorie_id" class="form-select">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $categorie)
                        <option value="{{ $categorie->id }}">
                            {{ $categorie->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Image du produit</label>
                <input type="file" name="image" class="file-upload-default">
                <div class="input-group col-xs-12">
                    <input type="text" class="form-control file-upload-info" disabled placeholder="Telecharge Image">
                    <span class="input-group-append">
                    <button class="file-upload-browse btn btn-gradient-primary py-3" type="button">Telecharger</button>
                    </span>
                </div>
                </div>
            <div class="form-group">
                <label for="exampleTextdescriptionarea1">Description du produit</label>
                <textarea class="form-control" name="description" id="description" rows="4"></textarea>
            </div>
            <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
            <button class="btn btn-light">Cancel</button>
        </form>
        </div>
    </div>
</div>
@endsection