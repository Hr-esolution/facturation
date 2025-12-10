@extends('layouts.app')

@section('content')
<style>
    :root {
        /* Pantone 2025 Colors */
        --pantone-2025-pepper-coral: #FF6B6B;
        --pantone-2025-ashen-aqua: #88BDBC;
        --pantone-2025-sweet-creme: #F9E7E1;
        --pantone-2025-slate-green: #6B8E8A;
        --pantone-2025-bright-amber: #F9C74F;
        --pantone-2025-deep-forest: #277DA1;
        --pantone-2025-soft-mint: #90BE6D;
    }
    
    .glass-card {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 16px;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.25);
        transition: all 0.3s ease;
    }
    
    .glass-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
    }
    
    .stat-card {
        background: linear-gradient(135deg, 
            rgba(255, 255, 255, 0.3), 
            rgba(255, 255, 255, 0.1));
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 12px;
    }
    
    .gradient-text {
        background: linear-gradient(135deg, 
            var(--pantone-2025-pepper-coral), 
            var(--pantone-2025-bright-amber));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .btn-glass {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 12px;
        padding: 10px 20px;
        color: #333;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-block;
    }
    
    .btn-glass:hover {
        background: rgba(255, 255, 255, 0.35);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        color: #333;
        text-decoration: none;
    }
    
    .btn-primary-glass {
        background: linear-gradient(135deg, 
            var(--pantone-2025-pepper-coral), 
            var(--pantone-2025-bright-amber));
        color: white !important;
        border: none;
    }
    
    .btn-secondary-glass {
        background: linear-gradient(135deg, 
            var(--pantone-2025-ashen-aqua), 
            var(--pantone-2025-slate-green));
        color: white !important;
        border: none;
    }
    
    .chart-container {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border-radius: 12px;
        padding: 20px;
    }
</style>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="glass-card p-4">
                <h1 class="gradient-text">Tableau de bord Utilisateur</h1>
                <p class="text-white">Bienvenue, {{ Auth::user()->name }}! Gérez vos activités.</p>
            </div>
        </div>
    </div>

    <!-- Statistiques personnelles -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="stat-card p-4 text-center">
                <div class="text-white">
                    <h3 class="mb-1">{{ \App\Models\Facture::where('user_id', Auth::user()->id)->count() ?? 0 }}</h3>
                    <p class="text-white/80 mb-0">Mes Factures</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="stat-card p-4 text-center">
                <div class="text-white">
                    <h3 class="mb-1">{{ \App\Models\Client::where('user_id', Auth::user()->id)->count() ?? 0 }}</h3>
                    <p class="text-white/80 mb-0">Mes Clients</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="stat-card p-4 text-center">
                <div class="text-white">
                    <h3 class="mb-1">{{ \App\Models\Emetteur::where('user_id', Auth::user()->id)->count() ?? 0 }}</h3>
                    <p class="text-white/80 mb-0">Mes Émetteurs</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="stat-card p-4 text-center">
                <div class="text-white">
                    <h3 class="mb-1">€{{ number_format(\App\Models\Facture::where('user_id', Auth::user()->id)->sum('montant_total') ?? 0, 2) }}</h3>
                    <p class="text-white/80 mb-0">Mes Revenus</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu utilisateur -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="glass-card p-4">
                <h4 class="text-white mb-4">Mes activités</h4>
                <div class="d-grid gap-2">
                    <!-- Mon Entreprise (Émetteurs) -->
                    <a href="{{ route('emetteurs.index') }}" class="btn-glass btn-primary-glass">
                        <i class="fas fa-building mr-2"></i> Mon Entreprise
                    </a>
                    
                    <!-- Mes Documents (Factures) -->
                    <a href="{{ route('factures.index') }}" class="btn-glass">
                        <i class="fas fa-file-invoice mr-2"></i> Mes Documents
                    </a>
                    
                    <!-- Mes Clients -->
                    <a href="{{ route('clients.index') }}" class="btn-glass">
                        <i class="fas fa-users mr-2"></i> Mes Clients
                    </a>
                    
                    <!-- Créer une nouvelle facture -->
                    <a href="{{ route('factures.create') }}" class="btn-glass btn-secondary-glass">
                        <i class="fas fa-plus mr-2"></i> Créer Document
                    </a>
                    
                    <!-- Paramètres Factures -->
                    <a href="{{ route('facture-parametres.index') }}" class="btn-glass">
                        <i class="fas fa-cogs mr-2"></i> Paramètres Factures
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 mb-4">
            <div class="glass-card p-4">
                <h4 class="text-white mb-4">Mes raccourcis</h4>
                <div class="d-grid gap-2">
                    <!-- Champs Factures selon pays -->
                    <a href="{{ route('admin.facture-champs.index') }}" class="btn-glass">
                        <i class="fas fa-edit mr-2"></i> Champs Factures
                    </a>
                    
                    <!-- Templates disponibles -->
                    <a href="{{ route('admin.facture-templates.index') }}" class="btn-glass">
                        <i class="fas fa-file-alt mr-2"></i> Templates
                    </a>
                    
                    <!-- Historique -->
                    <a href="{{ route('factures.index') }}" class="btn-glass">
                        <i class="fas fa-history mr-2"></i> Historique
                    </a>
                </div>
            </div>
            
            <div class="glass-card p-4 mt-4">
                <h4 class="text-white mb-4">Mes dernières factures</h4>
                <div class="list-group">
                    @forelse(\App\Models\Facture::where('user_id', Auth::user()->id)->latest()->take(5)->get() ?? collect([]) as $facture)
                        <a href="{{ route('factures.show', $facture->id) }}" class="list-group-item list-group-item-action glass-card mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-white">#{{ $facture->numero_facture }}</div>
                                    <small class="text-white/70">{{ $facture->created_at->format('d M Y') }}</small>
                                </div>
                                <div class="text-white font-weight-bold">
                                    €{{ number_format($facture->montant_total, 2) }}
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="text-white/70 text-center py-3">Aucune facture trouvée</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection