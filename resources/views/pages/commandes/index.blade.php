@extends('layouts.bootstrap')

@section('title', 'Mes commandes')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
@endif

<div class="container mt-4">
    <h2 class="text-purple-emphasis">🛒 Mes commandes</h2>

    @if($commandes->isEmpty())
        <div class="alert alert-warning mt-3">
            Vous n'avez passé aucune commande pour le moment.
        </div>
    @else
        <div class="row g-4">
            @foreach ($commandes as $commande)
                <div class="col-md-6">
                    <div class="card card-purple shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Commande #{{ $commande->id }}</h5>
                            <p class="card-text">
                                <strong>Date :</strong> {{ $commande->created_at->format('d/m/Y H:i') }} <br>
                                <strong>Statut :</strong>
                                <span class="badge {{ $commande->statut == 'annulée' ? 'bg-danger' : 'badge-purple' }}">
                                    {{ ucfirst($commande->statut ?? 'inconnu') }}
                                </span> <br>
                                <strong>Total :</strong> {{ number_format($commande->total, 0, ',', ' ') }} FCFA
                            </p>

                            <div class="d-flex gap-2 mt-3">
                                <button class="btn btn-purple btn-sm" data-bs-toggle="modal" data-bs-target="#commandeModal{{ $commande->id }}">
                                    Voir les détails
                                </button>

                                @if ($commande->statut === 'en cours')
                                    <form method="POST" action="{{ route('pages.commandes.delete', $commande->id) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Annuler cette commande ?')">
                                            Annuler la commande
                                        </button>
                                    </form>

                                    <button id="pay-btn-{{ $commande->id }}" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmPaiementModal{{ $commande->id }}">
                                        Payer
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal détails commande -->
                <div class="modal fade" id="commandeModal{{ $commande->id }}" tabindex="-1" aria-labelledby="commandeModalLabel{{ $commande->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header bg-light">
                                <h5 class="modal-title text-purple-emphasis" id="commandeModalLabel{{ $commande->id }}">
                                    Détails de la commande #{{ $commande->id }}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <ul class="list-group">
                                    @php
                                        $produitsCommande = \App\Models\ProduitCommande::where('commande_id', $commande->id)->get();
                                    @endphp

                                    @foreach ($produitsCommande as $pc)
                                        @php
                                            $produit = \App\Models\Produit::find($pc->produit_id);
                                        @endphp
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $produit->nom }}</strong><br>
                                                Quantité : {{ $pc->quantite }}<br>
                                                Prix unitaire : {{ number_format($produit->prix, 0, ',', ' ') }} FCFA
                                            </div>
                                            <span>
                                                {{ number_format($produit->prix * $pc->quantite, 0, ',', ' ') }} FCFA
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="text-end mt-3">
                                    <h5>Total : {{ number_format($commande->total, 0, ',', ' ') }} FCFA</h5>
                                </div>
                            </div>
                            <div class="modal-footer">
                                @if ($commande->statut === 'en cours')
                                    <form method="POST" action="{{ route('pages.commandes.delete', $commande->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Annuler cette commande ?')">
                                            Annuler la commande
                                        </button>
                                    </form>
                                @endif
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal paiement -->
                @if ($commande->statut === 'en cours')
                <div class="modal fade" id="confirmPaiementModal{{ $commande->id }}" tabindex="-1" aria-labelledby="confirmPaiementModalLabel{{ $commande->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-purple text-white">
                                <h5 class="modal-title" id="confirmPaiementModalLabel{{ $commande->id }}">Confirmation du Paiement</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Commande #{{ $commande->id }}</strong></p>
                                <p>Montant &agrave; payer : <strong>{{ number_format($commande->total, 0, ',', ' ') }} FCFA</strong></p>
                                <p>Statut : <span class="badge bg-warning text-dark">en cours</span></p>
                            </div>
                            <div class="modal-footer">
                                <button id="pay-btn-{{ $commande->id }}" class="btn btn-primary"
                                    onclick="confirmerPaiement({{ $commande->id }}, {{ $commande->total }})">
                                    Confirmer et payer
                                </button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

            @endforeach
        </div>
    @endif
</div>

<!-- Meta CSRF token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Script FedaPay -->
<script src="https://cdn.fedapay.com/checkout.js?v=1.1.7"></script>

<script>
const fedapayPublicKey = "{{ $fedapayPublicKey }}";

function confirmerPaiement(commandeId, montant) {
    fetch("{{ route('paiements.store') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            "Content-Type": "application/json",
            "Accept": "application/json"
        },
        body: JSON.stringify({
            commande_id: commandeId,
            montant: montant
        })
    })
    .then(response => {
        if (!response.ok) throw new Error("Erreur HTTP " + response.status);
        return response.json();
    })
    .then(data => {
        if (data.success) {
            try {
                // Initialisation Fedapay sur le bouton correspondant
                FedaPay.init('#pay-btn-' + commandeId, {
                    public_key: fedapayPublicKey,
                    transaction: {
                        amount: montant,
                        description: "Paiement de la commande #" + commandeId
                    },
                    onComplete: function(response) {
                        console.log("Paiement réussi :", response);
                        window.location.reload();
                    }
                });
            } catch (e) {
                console.error("Erreur dans FedaPay.init :", e.message || e);
                alert("Une erreur est survenue lors du démarrage du paiement.");
            }
        } else {
            alert("Erreur lors de l'enregistrement du paiement");
        }
    })
    .catch(error => {
        console.error("Erreur attrapée :", error);
        alert("Une erreur est survenue, consulte la console.");
    });
}
</script>

@endsection