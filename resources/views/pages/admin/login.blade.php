<!-- <!DOCTYPE html>
<html>
<head>
    <title>Connexion Admin</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-light p-4">
    <div class="container w-50 mt-5">
        <h2 class="text-center">Connexion Admin</h2>
        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nom d'utilisateur</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="mdp" class="form-control" required>
            </div>
            <button class="btn btn-primary w-100">Se connecter</button>
        </form>
    </div>
</body>
</html> -->
