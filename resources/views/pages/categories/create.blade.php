{{-- resources/views/categories/create.blade.php --}}
@extends('layouts.bootstrap')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
@endif
<div class="col-md-6 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h2 class="card-title">Ajouter une categorie de produit</h2>
        <form class="forms-sample" action="{{ route('pages.categories.store') }}" method="POST">
        @csrf
            <div class="form-group">
                <label for="nom">Nom de la categorie</label>
                <input type="text" class="form-control" name="nom" id="nom" placeholder="Entrer un nom...">
            </div>
            <div class="form-group">
                <label for="exampleTextdescriptionarea1">Description de la categorie</label>
                <textarea class="form-control" name="description" id="description" rows="4"></textarea>
            </div>
            <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
            <button class="btn btn-light">Cancel</button>
        </form>
        </div>
    </div>
</div>
@endsection