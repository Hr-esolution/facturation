@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Champs de Factures</h4>
                    <a href="{{ route('admin.facture-champs.create') }}" class="btn btn-primary float-end">Ajouter Champ</a>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Libellé</th>
                                <th>Pays</th>
                                <th>Obligatoire</th>
                                <th>Ordre</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($factureChamps as $champ)
                            <tr>
                                <td>{{ $champ->nom }}</td>
                                <td>{{ $champ->libelle }}</td>
                                <td>{{ $champ->pays ?: 'Tous' }}</td>
                                <td>
                                    <span class="badge bg-{{ $champ->obligatoire ? 'danger' : 'secondary' }}">
                                        {{ $champ->obligatoire ? 'Obligatoire' : 'Optionnel' }}
                                    </span>
                                </td>
                                <td>{{ $champ->ordre }}</td>
                                <td>
                                    <a href="{{ route('admin.facture-champs.edit', $champ->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                                    <form action="{{ route('admin.facture-champs.destroy', $champ->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    {{ $factureChamps->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection