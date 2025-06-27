{{-- resources/views/pages/produits/edit.blade.php --}}
@extends('layouts.bootstrap')

@section('content')

<div class="col-md-6 grid-margin stretch-card">
<div class="card">
    <div class="card-body">
    <h2 class="card-title">Modifier le produit {{$produit->nom}}</h2>
    <form class="forms-sample" action="{{ route('pages.produits.update', $produit->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
        <div class="form-group">
        <label for="nom">Nom du Produit</label>
        <input type="text" class="form-control" name="nom" id="nom" value="{{$produit->nom}}">
        </div>
        <div class="form-group">
        <label for="prix">Prix du Produit</label>
        <input type="text" class="form-control" name="prix" id="prix" value="{{$produit->prix}}">
        </div>
        <div class="form-group">
        <label for="stock">Stock du Produit</label>
        <input type="text" class="form-control" name="stock" id="stock" value="{{$produit->stock}}">
        </div>
        <div class="form-group">
        <label for="categorie_id">Catégorie du produit</label>
        <select class="form-select" id="categorie_id" name="categorie_id">
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
            <input type="text" class="form-control file-upload-info" disabled placeholder="Télécharger une Image">
            <span class="input-group-append">
            <button class="file-upload-browse btn btn-gradient-primary py-3" type="button">Télécharger</button>
            </span>
        </div>
        <div class="form-group">
            <label for="exampleTextdescriptionarea1">Description du produit</label>
            <textarea class="form-control" name="description" id="description" rows="4">{{$produit->description}}</textarea>
        </div>
        <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
        <button class="btn btn-light">Cancel</button>
    </form>
    </div>
</div>
</div>
@endsection