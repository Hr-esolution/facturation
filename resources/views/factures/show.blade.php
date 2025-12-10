@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Facture #{{ $facture->numero_facture }}</h4>
                    <div>
                        <a href="{{ route('factures.pdf', $facture->id) }}" class="btn btn-success">Télécharger PDF</a>
                        <a href="{{ route('factures.edit', $facture->id) }}" class="btn btn-warning">Éditer</a>
                        <a href="{{ route('factures.index') }}" class="btn btn-secondary">Retour</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Émetteur</h5>
                            <p>
                                <strong>{{ $facture->emetteur->entreprise ?? $facture->emetteur->nom }}</strong><br>
                                {{ $facture->emetteur->adresse ? json_encode($facture->emetteur->adresse) : '' }}<br>
                                {{ $facture->emetteur->ville }}, {{ $facture->emetteur->code_postal }}<br>
                                {{ $facture->emetteur->pays }}<br>
                                {{ $facture->emetteur->email ? 'Email: ' . $facture->emetteur->email : '' }}<br>
                                {{ $facture->emetteur->telephone ? 'Tél: ' . $facture->emetteur->telephone : '' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h5>Client</h5>
                            <p>
                                <strong>{{ $facture->client->entreprise ?? $facture->client->nom }}</strong><br>
                                {{ $facture->client->adresse ? json_encode($facture->client->adresse) : '' }}<br>
                                {{ $facture->client->ville }}, {{ $facture->client->code_postal }}<br>
                                {{ $facture->client->pays }}<br>
                                {{ $facture->client->email ? 'Email: ' . $facture->client->email : '' }}<br>
                                {{ $facture->client->telephone ? 'Tél: ' . $facture->client->telephone : '' }}
                            </p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p><strong>Date d'émission:</strong> {{ $facture->date_emission->format('d/m/Y') }}</p>
                            <p><strong>Date d'échéance:</strong> {{ $facture->date_echeance->format('d/m/Y') }}</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <p><strong>Statut:</strong> 
                                <span class="badge bg-{{ $facture->statut === 'payee' ? 'success' : ($facture->statut === 'envoyee' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($facture->statut) }}
                                </span>
                            </p>
                            <p><strong>Total HT:</strong> {{ number_format($facture->total_ht, 2, ',', ' ') }} €</p>
                            <p><strong>Total TVA:</strong> {{ number_format($facture->total_tva, 2, ',', ' ') }} €</p>
                            <p><strong>Total TTC:</strong> {{ number_format($facture->total_ttc, 2, ',', ' ') }} €</p>
                        </div>
                    </div>

                    <h5>Détail des produits</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Désignation</th>
                                    <th>Quantité</th>
                                    <th>Prix unitaire</th>
                                    <th>TVA</th>
                                    <th>Total HT</th>
                                    <th>Total TTC</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($facture->produits as $produit)
                                    @php
                                        $total_ht = $produit['quantite'] * $produit['prix_unitaire'];
                                        $total_tva = $total_ht * ($produit['taux_tva'] / 100);
                                        $total_ttc = $total_ht + $total_tva;
                                    @endphp
                                    <tr>
                                        <td>{{ $produit['designation'] }}</td>
                                        <td>{{ $produit['quantite'] }}</td>
                                        <td>{{ number_format($produit['prix_unitaire'], 2, ',', ' ') }} €</td>
                                        <td>{{ $produit['taux_tva'] }}%</td>
                                        <td>{{ number_format($total_ht, 2, ',', ' ') }} €</td>
                                        <td>{{ number_format($total_ttc, 2, ',', ' ') }} €</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <form action="{{ route('factures.send-email', $facture->id) }}" method="POST" class="me-2">
                            @csrf
                            <div class="input-group">
                                <input type="email" name="email" class="form-control" placeholder="Email du client" required>
                                <input type="hidden" name="pays" value="{{ $facture->pays_client }}">
                                <button type="submit" class="btn btn-primary">Envoyer par email</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection