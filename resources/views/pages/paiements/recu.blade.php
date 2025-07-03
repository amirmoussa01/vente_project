<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; color: #333; }
        .header { background-color: #6f42c1; color: white; padding: 10px; text-align: center; }
        .content { margin: 20px; }
        .footer { text-align: center; font-size: 12px; color: gray; margin-top: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <div class="header">
        <h2>E-Marchand - Reçu de Paiement</h2>
    </div>
    <div class="content">
        <p><strong>Paiement ID :</strong> #{{ $paiement->id }}</p>
        <p><strong>Date :</strong> {{ $paiement->date_paiement->format('d/m/Y H:i') }}</p>
        <p><strong>Commande :</strong> #{{ $paiement->commande->id }}</p>

        <h4>Produits achetés :</h4>
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix unitaire</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paiement->commande->produits as $produitCommande)
                <tr>
                    <td>{{ $produitCommande->produit->nom }}</td>
                    <td>{{ $produitCommande->quantite }}</td>
                    <td>{{ number_format($produitCommande->produit->prix, 0, ',', ' ') }} FCFA</td>
                    <td>{{ number_format($produitCommande->quantite * $produitCommande->produit->prix, 0, ',', ' ') }} FCFA</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p><strong>Montant total payé :</strong> {{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</p>
        <p><strong>Statut :</strong> {{ ucfirst($paiement->statut) }}</p>
    </div>

    <div class="footer">
        Merci d’avoir fait confiance à <strong>E-Marchand</strong>.
    </div>
</body>
</html>