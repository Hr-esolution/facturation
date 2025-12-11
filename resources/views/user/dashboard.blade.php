@extends('layouts.dashboard')

@section('page-title', 'Tableau de Bord')

@section('content')
<div class="container-fluid">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-1">Bonjour, {{ Auth::user()->name }} !</h2>
                            <p class="text-muted mb-0">Bienvenue sur votre tableau de bord de facturation</p>
                        </div>
                        <div class="text-end">
                            <small class="text-muted">Date du jour</small>
                            <h5 class="mb-0">{{ \Carbon\Carbon::now()->format('d M Y') }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-6 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total Factures</p>
                        <h3 class="mb-0 fw-bold">{{ \App\Models\Facture::where('user_id', Auth::user()->id)->count() ?? 0 }}</h3>
                        <small class="text-success"><i class="fas fa-arrow-up me-1"></i>+12%</small>
                    </div>
                    <div class="stat-icon bg-primary-light">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Clients Actifs</p>
                        <h3 class="mb-0 fw-bold">{{ \App\Models\Client::where('user_id', Auth::user()->id)->count() ?? 0 }}</h3>
                        <small class="text-success"><i class="fas fa-arrow-up me-1"></i>+5%</small>
                    </div>
                    <div class="stat-icon bg-success-light">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Revenus</p>
                        <h3 class="mb-0 fw-bold">€{{ number_format(\App\Models\Facture::where('user_id', Auth::user()->id)->sum('montant_total') ?? 0, 2) }}</h3>
                        <small class="text-danger"><i class="fas fa-arrow-down me-1"></i>-2%</small>
                    </div>
                    <div class="stat-icon bg-warning-light">
                        <i class="fas fa-euro-sign"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Produits</p>
                        <h3 class="mb-0 fw-bold">{{ \App\Models\Product::where('user_id', Auth::user()->id)->count() ?? 0 }}</h3>
                        <small class="text-success"><i class="fas fa-arrow-up me-1"></i>+8%</small>
                    </div>
                    <div class="stat-icon bg-info-light">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Cards -->
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3"><i class="fas fa-plus-circle text-primary me-2"></i>Créer Rapidement</h5>
                    <div class="d-grid gap-2">
                        <a href="{{ route('factures.create') }}" class="btn action-btn">
                            <i class="fas fa-file-invoice me-2"></i>Créer une Facture
                        </a>
                        <a href="{{ route('clients.create') }}" class="btn btn-outline-primary">
                            <i class="fas fa-user-plus me-2"></i>Ajouter un Client
                        </a>
                        <a href="{{ route('products.create') }}" class="btn btn-outline-success">
                            <i class="fas fa-box me-2"></i>Ajouter un Produit
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3"><i class="fas fa-chart-bar text-success me-2"></i>Statistiques Récents</h5>
                    <div class="progress mb-3" style="height: 10px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="mb-0"><strong>Taux de paiement:</strong> 75%</p>
                    <p class="text-muted small mb-0">75% des factures payées dans les délais</p>
                    
                    <div class="mt-3">
                        <p class="mb-1"><strong>Factures à payer:</strong> {{ \App\Models\Facture::where('user_id', Auth::user()->id)->where('etat_paiement', '!=', 'payee')->count() ?? 0 }}</p>
                        <p class="text-muted small mb-0"><i class="fas fa-exclamation-triangle text-warning me-1"></i>Échéances cette semaine</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title fw-bold mb-0"><i class="fas fa-history text-info me-2"></i>Dernières Factures</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse(\App\Models\Facture::where('user_id', Auth::user()->id)->latest()->take(3)->get() ?? collect([]) as $facture)
                        <div class="recent-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1 fw-semibold">#{{ $facture->numero_facture }}</h6>
                                    <small class="text-muted">Client: {{ $facture->client->nom ?? 'N/A' }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge @if($facture->etat_paiement == 'payee') bg-success @elseif($facture->etat_paiement == 'en_attente') bg-warning @else bg-danger @endif">{{ ucfirst(str_replace('_', ' ', $facture->etat_paiement)) }}</span>
                                    <small class="d-block text-muted">€{{ number_format($facture->montant_total, 2) }}</small>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="recent-item text-center">
                            <p class="text-muted mb-0">Aucune facture trouvée</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title fw-bold mb-0"><i class="fas fa-calendar-check text-warning me-2"></i>Factures Échues</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse(\App\Models\Facture::where('user_id', Auth::user()->id)->where('date_echeance', '<', now())->where('etat_paiement', '!=', 'payee')->take(3)->get() ?? collect([]) as $facture)
                        <div class="recent-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1 fw-semibold">#{{ $facture->numero_facture }}</h6>
                                    <small class="text-muted">Échéance: {{ $facture->date_echeance->format('d M Y') }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-danger">€{{ number_format($facture->montant_total, 2) }}</span>
                                    <small class="d-block text-muted">{{ $facture->client->nom ?? 'N/A' }}</small>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="recent-item text-center">
                            <p class="text-muted mb-0">Aucune facture échue</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection