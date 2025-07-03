{{-- resources/views/categories/create.blade.php --}}
@extends('layouts.bootstrap')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
@endif
<div class="row">
    <div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
        <h4 class="card-title">Liste des categories</h4>
        <div class="table-responsive">
            <table class="table">
            <thead>
                <tr>
                <th scope="col"> # </th>
                <th scope="col"> Nom de la categorie </th>
                <th scope="col"> Description </th>
                <th scope="col"> Actions </th>
                </tr>
            </thead>
            <tbody>
                
                @foreach($categories as $key => $categorie)
                <tr>
                    <td>
                        {{ $key+ 1 }}
                    </td>
                    <td>
                        {{ $categorie->nom }}
                    </td>
                    <td>
                        {{ $categorie->description }}
                    </td>
                    <td>
                        <a href="{{ route('pages.categories.edit', $categorie->id) }}" class="btn btn-warning btn-sm">Modifier</a><br><br>
                        
                        <form action="{{ route('pages.categories.destroy', $categorie->id) }}" method="POST" onsubmit="return confirm('Supprimer cette categorie ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach;
            </tbody>
            </table>
        </div>
        </div>
    </div>
    </div>
</div>
@endsection