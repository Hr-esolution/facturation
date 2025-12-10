<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture {{ $facture['numero_facture'] }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .company-info { float: left; width: 45%; }
        .client-info { float: right; width: 45%; }
        .invoice-details { clear: both; margin: 20px 0; }
        .products-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .products-table th, .products-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .products-table th { background-color: #f2f2f2; }
        .totals { text-align: right; margin: 20px 0; }
        .footer { margin-top: 40px; text-align: center; font-size: 0.8em; }
    </style>
</head>
<body>
    <div class="header">
        <h1>FACTURE</h1>
    </div>
    
    <div class="company-info">
        <h3>Émetteur</h3>
        <p>{{ $facture['emetteur']['nom'] ?? '' }}</p>
        <p>{{ $facture['emetteur']['adresse'] ?? '' }}</p>
        <p>{{ $facture['emetteur']['numero_tva'] ?? '' }}</p>
    </div>
    
    <div class="client-info">
        <h3>Client</h3>
        <p>{{ $facture['client']['nom'] ?? '' }}</p>
        <p>{{ $facture['client']['adresse'] ?? '' }}</p>
        @if(!empty($facture['client']['numero_tva_intracommunautaire']))
            <p>{{ __('Numéro TVA Intracommunautaire') }}: {{ $facture['client']['numero_tva_intracommunautaire'] }}</p>
        @endif
    </div>
    
    <div class="invoice-details">
        <p><strong>{{ __('Numéro de facture') }}:</strong> {{ $facture['numero_facture'] }}</p>
        <p><strong>{{ __('Date d\'émission') }}:</strong> {{ $facture['date_emission'] }}</p>
        <p><strong>{{ __('Date d\'échéance') }}:</strong> {{ $facture['date_echeance'] ?? '' }}</p>
    </div>
    
    <table class="products-table">
        <thead>
            <tr>
                <th>{{ __('Désignation') }}</th>
                <th>{{ __('Quantité') }}</th>
                <th>{{ __('Prix unitaire') }}</th>
                <th>{{ __('TVA (%)') }}</th>
                <th>{{ __('Montant HT') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($facture['produits'] as $produit)
            <tr>
                <td>{{ $produit['designation'] }}</td>
                <td>{{ $produit['quantite'] }}</td>
                <td>{{ number_format($produit['prix_unitaire'], 2, ',', ' ') }} {{ $facture['devise'] ?? 'EUR' }}</td>
                <td>{{ $produit['taux_tva'] }}%</td>
                <td>{{ number_format($produit['quantite'] * $produit['prix_unitaire'], 2, ',', ' ') }} {{ $facture['devise'] ?? 'EUR' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="totals">
        <p><strong>{{ __('Total HT') }}:</strong> {{ number_format($facture['total_ht'], 2, ',', ' ') }} {{ $facture['devise'] ?? 'EUR' }}</p>
        <p><strong>{{ __('TVA') }}:</strong> {{ number_format($facture['total_tva'], 2, ',', ' ') }} {{ $facture['devise'] ?? 'EUR' }}</p>
        <p><strong>{{ __('Total TTC') }}:</strong> {{ number_format($facture['total_ttc'], 2, ',', ' ') }} {{ $facture['devise'] ?? 'EUR' }}</p>
    </div>
    
    <div class="footer">
        <p>{{ __('Document émis électroniquement - Fait foi de créance') }}</p>
        @if(!empty($facture['mentions_legales']))
            <p>{{ $facture['mentions_legales'] }}</p>
        @endif
    </div>
</body>
</html>