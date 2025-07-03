@extends('layouts.bootstrap')

@section('content')
<div class="container mt-5">
    <h2 class="text-center text-purple mb-4">Mes Paiements</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered shadow">
            <thead class="bg-purple text-white">
                <tr>
                    <th>#</th>
                    <th>Commande</th>
                    <th>Montant</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Reçu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($paiements as $paiement)
                <tr>
                    <td>{{ $paiement->id }}</td>
                    <td>#{{ $paiement->commande_id }}</td>
                    <td>{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</td>
                    <td>{{ $paiement->date_paiement->format('d/m/Y H:i') }}</td>
                    <td><span class="badge bg-warning text-dark">{{ ucfirst($paiement->statut) }}</span></td>
                    <td>
                        <a href="{{ route('paiements.recu', $paiement->id) }}" class="btn btn-sm btn-outline-purple">
                            <i class="bi bi-file-earmark-pdf"></i> PDF
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Aucun paiement trouvé</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
