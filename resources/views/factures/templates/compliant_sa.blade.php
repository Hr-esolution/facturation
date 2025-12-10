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
        .zatca-section { border: 2px solid #000; padding: 10px; margin: 10px 0; }
        .qr-code { float: right; margin-left: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>FACTURE</h1>
    </div>
    
    <div class="company-info">
        <h3>البائع / Seller</h3>
        <p><strong>{{ $facture['emetteur']['nom'] ?? '' }}</strong></p>
        <p>{{ $facture['emetteur']['adresse'] ?? '' }}</p>
        <p><strong>رقم الم-tax identification number:</strong> {{ $facture['emetteur']['numero_tva'] ?? '' }}</p>
    </div>
    
    <div class="client-info">
        <h3>المشتري / Buyer</h3>
        <p><strong>{{ $facture['client']['nom'] ?? '' }}</strong></p>
        <p>{{ $facture['client']['adresse'] ?? '' }}</p>
        @if(!empty($facture['client']['numero_tva_intracommunautaire']))
            <p><strong>رقم ضريبة القيمة المضافة:</strong> {{ $facture['client']['numero_tva_intracommunautaire'] }}</p>
        @endif
    </div>
    
    <div class="invoice-details">
        <p><strong>{{ __('Numéro de facture') }}:</strong> {{ $facture['numero_facture'] }}</p>
        <p><strong>{{ __('Date d\'émission') }}:</strong> {{ $facture['date_emission'] }}</p>
        <p><strong>{{ __('Date d\'échéance') }}:</strong> {{ $facture['date_echeance'] ?? '' }}</p>
    </div>
    
    <div class="zatca-section">
        <h3>متطلبات ZATCA</h3>
        <p><strong>{{ __('Conforme aux exigences ZATCA saoudiennes') }}</strong></p>
        <p>{{ __('Facture قابلة للتحقق ضريبيًا') }}</p>
        @if(!empty($facture['qr_code_path']))
            <div class="qr-code">
                <img src="{{ storage_path('app/' . $facture['qr_code_path']) }}" alt="QR Code Fiscal ZATCA" style="width: 100px; height: 100px;">
            </div>
        @endif
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
                <td>{{ number_format($produit['prix_unitaire'], 2, ',', ' ') }} {{ $facture['devise'] ?? 'SAR' }}</td>
                <td>{{ $produit['taux_tva'] }}%</td>
                <td>{{ number_format($produit['quantite'] * $produit['prix_unitaire'], 2, ',', ' ') }} {{ $facture['devise'] ?? 'SAR' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="totals">
        <p><strong>{{ __('Total HT') }}:</strong> {{ number_format($facture['total_ht'], 2, ',', ' ') }} {{ $facture['devise'] ?? 'SAR' }}</p>
        <p><strong>{{ __('TVA') }}:</strong> {{ number_format($facture['total_tva'], 2, ',', ' ') }} {{ $facture['devise'] ?? 'SAR' }}</p>
        <p><strong>{{ __('Total TTC') }}:</strong> {{ number_format($facture['total_ttc'], 2, ',', ' ') }} {{ $facture['devise'] ?? 'SAR' }}</p>
    </div>
    
    <div class="footer">
        <p>{{ __('Document émis électroniquement - Fait foi de créance') }}</p>
        <p>{{ __('Conforme aux exigences ZATCA saoudiennes pour facturation électronique') }}</p>
        <p>{{ __('الوثيقة الصادرة إلكترونياً - تشكل حجة مالية') }}</p>
        @if(!empty($facture['signature_data']))
            <div style="margin-top: 10px; padding: 5px; border: 1px solid #ccc;">
                <p><strong>{{ __('Signature électronique') }}:</strong></p>
                <p>{{ __('Date et heure:') }} {{ $facture['signature_data']['timestamp'] ?? '' }}</p>
                <p>{{ __('Type:') }} {{ $facture['signature_data']['signature_type'] ?? '' }}</p>
                <p>{{ __('ID Facture:') }} {{ $facture['signature_data']['facture_id'] ?? '' }}</p>
            </div>
        @endif
    </div>
</body>
</html>