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
        .tax-info { background-color: #f9f9f9; padding: 10px; border: 1px solid #ddd; margin: 10px 0; }
        .products-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .products-table th, .products-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .products-table th { background-color: #f2f2f2; }
        .totals { text-align: right; margin: 20px 0; }
        .footer { margin-top: 40px; text-align: center; font-size: 0.8em; }
        .required-fields { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>FACTURE</h1>
    </div>
    
    <div class="company-info">
        <h3>Émetteur</h3>
        <p><span class="required-fields">*</span> <strong>{{ $facture['emetteur']['nom'] ?? '' }}</strong></p>
        <p>{{ $facture['emetteur']['adresse'] ?? '' }}</p>
        <p><span class="required-fields">*</span> <strong>ICE:</strong> {{ $facture['emetteur']['ice'] ?? '' }}</p>
        <p><span class="required-fields">*</span> <strong>IF:</strong> {{ $facture['emetteur']['if'] ?? '' }}</p>
        <p><span class="required-fields">*</span> <strong>RC:</strong> {{ $facture['emetteur']['rc'] ?? '' }}</p>
        <p><span class="required-fields">*</span> <strong>Patente:</strong> {{ $facture['emetteur']['patente'] ?? '' }}</p>
        @if(!empty($facture['emetteur']['cnss']))
            <p><strong>CNSS:</strong> {{ $facture['emetteur']['cnss'] ?? '' }}</p>
        @endif
        <p>{{ $facture['emetteur']['numero_tva'] ?? '' }}</p>
    </div>
    
    <div class="client-info">
        <h3>Client</h3>
        <p><strong>{{ $facture['client']['nom'] ?? '' }}</strong></p>
        <p>{{ $facture['client']['adresse'] ?? '' }}</p>
        @if(!empty($facture['client']['ice']))
            <p><span class="required-fields">*</span> <strong>ICE:</strong> {{ $facture['client']['ice'] }}</p>
        @endif
        @if(!empty($facture['client']['if']))
            <p><strong>IF:</strong> {{ $facture['client']['if'] }}</p>
        @endif
        @if(!empty($facture['client']['rc']))
            <p><strong>RC:</strong> {{ $facture['client']['rc'] }}</p>
        @endif
    </div>
    
    <div class="invoice-details">
        <p><span class="required-fields">*</span> <strong>{{ __('Numéro de facture') }}:</strong> {{ $facture['numero_facture'] }}</p>
        <p><span class="required-fields">*</span> <strong>{{ __('Date d\'émission') }}:</strong> {{ $facture['date_emission'] }}</p>
        <p><span class="required-fields">*</span> <strong>{{ __('Date d\'échéance') }}:</strong> {{ $facture['date_echeance'] ?? '' }}</p>
        @if(!empty($facture['reference_client']))
            <p><strong>{{ __('Référence du client') }}:</strong> {{ $facture['reference_client'] }}</p>
        @endif
        @if(!empty($facture['mode_paiement']))
            <p><span class="required-fields">*</span> <strong>{{ __('Mode de paiement') }}:</strong> {{ $facture['mode_paiement'] }}</p>
        @endif
    </div>
    
    <div class="tax-info">
        <p><strong>{{ __('Facture conforme aux dispositions fiscales marocaines') }}</strong></p>
        <p>{{ __('Soumis aux obligations fiscales prévues par la législation marocaine') }}</p>
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
                <td>{{ number_format($produit['prix_unitaire'], 2, ',', ' ') }} {{ $facture['devise'] ?? 'MAD' }}</td>
                <td>{{ $produit['taux_tva'] }}%</td>
                <td>{{ number_format($produit['quantite'] * $produit['prix_unitaire'], 2, ',', ' ') }} {{ $facture['devise'] ?? 'MAD' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="totals">
        <p><strong>{{ __('Total HT') }}:</strong> {{ number_format($facture['total_ht'], 2, ',', ' ') }} {{ $facture['devise'] ?? 'MAD' }}</p>
        <p><strong>{{ __('TVA') }}:</strong> {{ number_format($facture['total_tva'], 2, ',', ' ') }} {{ $facture['devise'] ?? 'MAD' }}</p>
        <p><strong>{{ __('Total TTC') }}:</strong> {{ number_format($facture['total_ttc'], 2, ',', ' ') }} {{ $facture['devise'] ?? 'MAD' }}</p>
    </div>
    
    <div class="footer">
        <p>{{ __('Document officiel de facturation - Fait foi de créance') }}</p>
        <p>{{ __('Conforme aux dispositions du CGI marocain') }}</p>
        <p>{{ __('Doit être conservé pendant 5 ans') }}</p>
        @if(!empty($facture['champs_dynamiques']))
            @foreach($facture['champs_dynamiques'] as $champ)
                @if($champ['requis'] && !empty($facture[$champ['nom']]))
                    <p><strong>{{ $champ['label'] }}:</strong> {{ $facture[$champ['nom']] }}</p>
                @endif
            @endforeach
        @endif
    </div>
</body>
</html>