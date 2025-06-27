<!-- @extends('layouts.app')

@section('content')
<div class="container">
    <h2>Liste des Admins</h2>
    <a href="{{ route('admins.create') }}" class="btn btn-success mb-3">Ajouter un admin</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom d'utilisateur</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($admins as $admin)
            <tr>
                <td>{{ $admin->id }}</td>
                <td>{{ $admin->username }}</td>
                <td>
                    <a href="{{ route('admins.edit', $admin) }}" class="btn btn-sm btn-warning">Modifier</a>
                    <form action="{{ route('admins.destroy', $admin) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection -->
