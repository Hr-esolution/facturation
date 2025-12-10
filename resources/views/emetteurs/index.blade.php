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
    
    .glass-table {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 12px;
        overflow: hidden;
    }
    
    .btn-glass {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 12px;
        padding: 8px 16px;
        color: #333;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-block;
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
    
    .table th {
        border-top: none;
        color: white;
    }
    
    .table td {
        color: rgba(255, 255, 255, 0.9);
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .search-box {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 12px;
        padding: 10px 15px;
    }
</style>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="glass-card p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="text-white mb-0">Gestion des Émetteurs</h1>
                    <a href="{{ route('emetteurs.create') }}" class="btn-glass btn-primary-glass">
                        <i class="fas fa-plus mr-2"></i> Nouvel Émetteur
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="glass-card p-4 mb-4">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="search-box">
                            <input type="text" class="form-control bg-transparent text-white border-0" placeholder="Rechercher un émetteur..." style="background: transparent;">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex gap-2 justify-content-md-end">
                            <select class="form-select bg-transparent text-white border-0 search-box" style="background: transparent;">
                                <option>Tous les types</option>
                                <option>Entreprise</option>
                                <option>Individuel</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="glass-table">
                <div class="table-responsive">
                    <table class="table table-borderless mb-0">
                        <thead class="bg-transparent">
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Pays</th>
                                <th>Type</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($emetteurs ?? collect([]) as $emetteur)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $emetteur->nom }}</div>
                                        <small class="text-white/70">{{ $emetteur->prenom ?? '' }}</small>
                                    </td>
                                    <td>{{ $emetteur->email }}</td>
                                    <td>{{ $emetteur->telephone }}</td>
                                    <td>{{ $emetteur->pays }}</td>
                                    <td>
                                        <span class="badge" style="background: rgba(136, 189, 188, 0.3); color: white; border: 1px solid rgba(136, 189, 188, 0.5);">
                                            {{ $emetteur->type ?? 'Entreprise' }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex gap-2 justify-content-end">
                                            <a href="{{ route('emetteurs.show', $emetteur->id) }}" class="btn-glass btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('emetteurs.edit', $emetteur->id) }}" class="btn-glass btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('emetteurs.destroy', $emetteur->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-glass btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet émetteur ?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-white/70">
                                        Aucun émetteur trouvé
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="p-3 border-top" style="border-color: rgba(255, 255, 255, 0.1) !important;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-white/70">
                            Affichage de 1 à {{ $emetteurs->count() ?? 0 }} sur {{ $emetteurs->total() ?? $emetteurs->count() ?? 0 }} entrées
                        </div>
                        <nav>
                            <ul class="pagination mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link bg-transparent text-white border-0" href="#" tabindex="-1">Précédent</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link bg-transparent text-white border-0" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link bg-transparent text-white border-0" href="#">Suivant</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection