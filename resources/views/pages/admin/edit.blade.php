<!-- @extends('layouts.app')

@section('content')
<div class="container">
    <h2>Modifier l'Admin</h2>

    <form method="POST" action="{{ route('admins.update', $admin) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nom d'utilisateur</label>
            <input type="text" name="username" class="form-control" value="{{ $admin->username }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nouveau mot de passe (optionnel)</label>
            <input type="password" name="mdp" class="form-control">
        </div>

        <button class="btn btn-primary">Modifier</button>
    </form>
</div>
@endsection -->
