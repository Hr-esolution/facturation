@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4>Liste des Factures</h4>
                        <a href="{{ route('factures.create') }}" class="btn btn-primary">Créer une facture</a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Numéro</th>
                                    <th>Émetteur</th>
                                    <th>Client</th>
                                    <th>Date Émission</th>
                                    <th>Date Échéance</th>
                                    <th>Total TTC</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($factures as $facture)
                                    <tr>
                                        <td>{{ $facture->id }}</td>
                                        <td>{{ $facture->numero_facture }}</td>
                                        <td>{{ $facture->emetteur->entreprise ?? $facture->emetteur->nom }}</td>
                                        <td>{{ $facture->client->entreprise ?? $facture->client->nom }}</td>
                                        <td>{{ $facture->date_emission->format('d/m/Y') }}</td>
                                        <td>{{ $facture->date_echeance->format('d/m/Y') }}</td>
                                        <td>{{ number_format($facture->total_ttc, 2, ',', ' ') }} €</td>
                                        <td>
                                            <span class="badge bg-{{ $facture->statut === 'payee' ? 'success' : ($facture->statut === 'envoyee' ? 'warning' : 'secondary') }}">
                                                {{ ucfirst($facture->statut) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('factures.show', $facture->id) }}" class="btn btn-sm btn-info">Voir</a>
                                                <a href="{{ route('factures.edit', $facture->id) }}" class="btn btn-sm btn-warning">Éditer</a>
                                                <a href="{{ route('factures.pdf', $facture->id) }}" class="btn btn-sm btn-success">PDF</a>
                                                <form action="{{ route('factures.destroy', $facture->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette facture ?')">Supprimer</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Aucune facture trouvée</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $factures->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection