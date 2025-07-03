@extends('layouts.bootstrap')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
@endif
    <div class="container py-4">
        <h2 class="text-purple">🛒 Votre panier</h2>

        @if ($panier->produits->isEmpty())
            <p>Votre panier est vide.</p>
            <div class="d-flex gap-2 mt-3">
                <a href="{{ route('pages.produits.index') }}" class="btn btn-secondary">Ajouter un produit</a>
            </div>
        @else
            @php
                $total = 0;
            @endphp
            <div class="row">
                @foreach ($panier->produits as $item)
                    @php
                        $produit = $item->produit;
                        $sousTotal = $produit->prix * $item->quantite;
                        $total += $sousTotal;
                    @endphp
                    <div class="card shadow-sm" style="background-color: #f9fafb;"><hr>
                    <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('storage/produits/' . $produit->image) }}" alt="{{ $produit->nom }}" width="50" height="50" class="rounded me-3" />
                            <div>
                                <div class="fw-semibold">{{ $produit->nom }}</div>
                                <div class="text-muted small">{{ $item->quantite }} x {{ number_format($produit->prix, 2) }} FCFA</div>
                            </div>
                        </div>

                        <div class="text-end">
                            <div class="fw-bold">{{ number_format($sousTotal, 2) }} FCFA</div>
                            <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#modifierQuantiteModal{{ $item->id }}">
                                <i class="bi bi-pencil"></i>
                            </button>

                            <form action="{{ route('pages.paniers.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer ce produit ?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                        </div>
                    </div>
                        <!-- Modal Modifier quantité -->
                        <div class="modal fade" id="modifierQuantiteModal{{ $item->id }}" tabindex="-1" aria-labelledby="modifierQuantiteModalLabel{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('pages.paniers.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT') 
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modifierQuantiteModalLabel{{ $item->id }}">Modifier la quantité</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                        </div>
                                        <div class="modal-body">
                                            <label for="quantite">Quantité pour {{ $item->produit->nom }}</label>
                                            <input type="number" name="quantite" id="quantite" class="form-control" value="{{ $item->quantite }}" min="1" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div><hr>
                @endforeach
            </div>
            <div class="mt-4">
                <h4>Total : {{ number_format($total, 2) }} FCFA</h4>

                <div class="d-flex gap-2 mt-3">
                    <form action="{{ route('pages.paniers.delete',$panier->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Vraiment vider ce panier ?')">Vider le panier</button>
                    </form>                    
                    <a href="{{ route('pages.produits.index') }}" class="btn btn-secondary">Ajouter un produit</a>
                    <!-- Bouton Commander -->
                    @if (!$panier->produits->isEmpty())
                            <button class="btn btn-purple" data-bs-toggle="modal" data-bs-target="#commanderModal">
                                Commander
                            </button>
                    @endif

                    <!-- Modal Commander -->
                    <div class="modal fade" id="commanderModal" tabindex="-1" aria-labelledby="commanderModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h5 class="modal-title text-purple-emphasis" id="commanderModalLabel">
                                        Confirmer la commande
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <ul class="list-group">
                                        @php $total = 0; @endphp

                                        @foreach ($panier->produits as $item)
                                            @php
                                                $produit = $item->produit;
                                                $sousTotal = $produit->prix * $item->quantite;
                                                $total += $sousTotal;
                                            @endphp
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $produit->nom }}</strong><br>
                                                    Quantité : {{ $item->quantite }}<br>
                                                    Prix unitaire : {{ number_format($produit->prix, 0, ',', ' ') }} FCFA
                                                </div>
                                                <span>
                                                    {{ number_format($sousTotal, 0, ',', ' ') }} FCFA
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <div class="text-end mt-3">
                                        <h5>Total à payer : {{ number_format($total, 0, ',', ' ') }} FCFA</h5>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <form method="POST" action="{{ route('pages.commandes.store') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-purple">
                                            Confirmer la commande
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

@endsection
