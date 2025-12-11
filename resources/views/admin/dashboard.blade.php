@extends('layouts.dashboard')

@section('page-title', 'Dashboard Admin')

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
                            <p class="text-muted mb-0">Espace administrateur - Gestion du système de facturation</p>
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
                        <p class="text-muted mb-1">Total Utilisateurs</p>
                        <h3 class="mb-0 fw-bold">{{ \App\Models\User::count() }}</h3>
                        <small class="text-success"><i class="fas fa-arrow-up me-1"></i>+5%</small>
                    </div>
                    <div class="stat-icon bg-primary-light">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total Factures</p>
                        <h3 class="mb-0 fw-bold">{{ \App\Models\Facture::count() }}</h3>
                        <small class="text-success"><i class="fas fa-arrow-up me-1"></i>+12%</small>
                    </div>
                    <div class="stat-icon bg-success-light">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Revenus Totaux</p>
                        <h3 class="mb-0 fw-bold">€{{ number_format(\App\Models\Facture::sum('montant_total'), 2) }}</h3>
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
                        <p class="text-muted mb-1">Templates</p>
                        <h3 class="mb-0 fw-bold">{{ \App\Models\FactureTemplate::count() }}</h3>
                        <small class="text-success"><i class="fas fa-arrow-up me-1"></i>+3%</small>
                    </div>
                    <div class="stat-icon bg-info-light">
                        <i class="fas fa-file-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Actions -->
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3"><i class="fas fa-cogs text-primary me-2"></i>Gestion Système</h5>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.facture-templates.index') }}" class="btn action-btn">
                            <i class="fas fa-file-alt me-2"></i>Gérer les Templates
                        </a>
                        <a href="{{ route('admin.facture-champs.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-2"></i>Gérer les Champs de Facture
                        </a>
                        <a href="#" class="btn btn-outline-success">
                            <i class="fas fa-users me-2"></i>Gérer les Utilisateurs
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3"><i class="fas fa-chart-bar text-success me-2"></i>Statistiques Globales</h5>
                    <div class="progress mb-3" style="height: 10px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="mb-0"><strong>Taux de conformité:</strong> 95%</p>
                    <p class="text-muted small mb-0">Conformité aux exigences internationales</p>
                    
                    <div class="mt-3">
                        <p class="mb-1"><strong>Utilisateurs actifs:</strong> {{ \App\Models\User::where('status', 'approuve')->count() }}</p>
                        <p class="text-muted small mb-0"><i class="fas fa-user-check text-success me-1"></i>Utilisateurs approuvés</p>
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
                    <h5 class="card-title fw-bold mb-0"><i class="fas fa-history text-info me-2"></i>Dernières Activités</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse(\App\Models\Facture::latest()->take(3)->get() ?? collect([]) as $facture)
                        <div class="recent-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1 fw-semibold">#{{ $facture->numero_facture }}</h6>
                                    <small class="text-muted">Créée le {{ $facture->created_at->format('d M Y') }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-success">€{{ number_format($facture->montant_total, 2) }}</span>
                                    <small class="d-block text-muted">{{ $facture->user->name ?? 'N/A' }}</small>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="recent-item text-center">
                            <p class="text-muted mb-0">Aucune activité récente</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title fw-bold mb-0"><i class="fas fa-user-check text-warning me-2"></i>Utilisateurs en attente</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse(\App\Models\User::where('status', 'non_approuve')->take(3)->get() ?? collect([]) as $user)
                        <div class="recent-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1 fw-semibold">{{ $user->name }}</h6>
                                    <small class="text-muted">{{ $user->email }}</small>
                                </div>
                                <div class="text-end">
                                    <a href="#" class="btn btn-sm btn-success">Approuver</a>
                                    <small class="d-block text-muted">Inscrit {{ $user->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="recent-item text-center">
                            <p class="text-muted mb-0">Aucun utilisateur en attente</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection