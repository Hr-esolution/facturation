@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Paramètres Factures</h4>
                    <a href="{{ route('facture-parametres.create') }}" class="btn btn-primary float-end">Ajouter Paramètre</a>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Clef</th>
                                <th>Valeur</th>
                                <th>Pays</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($factureParametres as $parametre)
                            <tr>
                                <td>{{ $parametre->cle }}</td>
                                <td>{{ $parametre->valeur }}</td>
                                <td>{{ $parametre->pays }}</td>
                                <td>{{ $parametre->description }}</td>
                                <td>
                                    <a href="{{ route('facture-parametres.edit', $parametre->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                                    <form action="{{ route('facture-parametres.destroy', $parametre->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    {{ $factureParametres->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection