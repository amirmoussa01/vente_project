<!-- @extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Ajouter un Admin</h2>

    <form method="POST" action="{{ route('admins.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nom d'utilisateur</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Mot de passe</label>
            <input type="password" name="mdp" class="form-control" required>
        </div>

        <button class="btn btn-primary">Ajouter</button>
    </form>
</div>
@endsection -->
