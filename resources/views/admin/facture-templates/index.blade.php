@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Templates de Factures</h4>
                    <a href="{{ route('admin.facture-templates.create') }}" class="btn btn-primary float-end">Ajouter Template</a>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Statut</th>
                                <th>Défaut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($factureTemplates as $template)
                            <tr>
                                <td>{{ $template->nom }}</td>
                                <td>{{ $template->description }}</td>
                                <td>
                                    <span class="badge bg-{{ $template->statut ? 'success' : 'secondary' }}">
                                        {{ $template->statut ? 'Actif' : 'Inactif' }}
                                    </span>
                                </td>
                                <td>
                                    @if($template->defaut)
                                        <span class="badge bg-info">Défaut</span>
                                    @else
                                        <form action="{{ route('admin.facture-templates.set-default', $template->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-outline-info">Définir par défaut</button>
                                        </form>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.facture-templates.edit', $template->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                                    <form action="{{ route('admin.facture-templates.toggle-status', $template->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-{{ $template->statut ? 'danger' : 'success' }}">
                                            {{ $template->statut ? 'Désactiver' : 'Activer' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.facture-templates.destroy', $template->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    {{ $factureTemplates->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection