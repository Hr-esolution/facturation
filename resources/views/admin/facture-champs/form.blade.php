@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>{{ isset($factureChamp) ? 'Modifier Champ' : 'Créer Champ' }}</h4>
                </div>
                
                <div class="card-body">
                    <form action="{{ isset($factureChamp) ? route('admin.facture-champs.update', $factureChamp->id) : route('admin.facture-champs.store') }}" method="POST">
                        @csrf
                        @if(isset($factureChamp))
                            @method('PUT')
                        @endif
                        
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom', $factureChamp->nom ?? '') }}" required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="libelle" class="form-label">Libellé</label>
                            <input type="text" class="form-control @error('libelle') is-invalid @enderror" id="libelle" name="libelle" value="{{ old('libelle', $factureChamp->libelle ?? '') }}" required>
                            @error('libelle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="pays" class="form-label">Pays</label>
                            <select class="form-control @error('pays') is-invalid @enderror" id="pays" name="pays">
                                <option value="">Tous les pays</option>
                                <option value="FR" {{ (old('pays', $factureChamp->pays ?? '')) == 'FR' ? 'selected' : '' }}>France</option>
                                <option value="MA" {{ (old('pays', $factureChamp->pays ?? '')) == 'MA' ? 'selected' : '' }}>Maroc</option>
                                <option value="CA" {{ (old('pays', $factureChamp->pays ?? '')) == 'CA' ? 'selected' : '' }}>Canada</option>
                                <option value="BE" {{ (old('pays', $factureChamp->pays ?? '')) == 'BE' ? 'selected' : '' }}>Belgique</option>
                                <option value="CH" {{ (old('pays', $factureChamp->pays ?? '')) == 'CH' ? 'selected' : '' }}>Suisse</option>
                            </select>
                            @error('pays')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="text" {{ (old('type', $factureChamp->type ?? '')) == 'text' ? 'selected' : '' }}>Texte</option>
                                <option value="number" {{ (old('type', $factureChamp->type ?? '')) == 'number' ? 'selected' : '' }}>Nombre</option>
                                <option value="date" {{ (old('type', $factureChamp->type ?? '')) == 'date' ? 'selected' : '' }}>Date</option>
                                <option value="email" {{ (old('type', $factureChamp->type ?? '')) == 'email' ? 'selected' : '' }}>Email</option>
                                <option value="select" {{ (old('type', $factureChamp->type ?? '')) == 'select' ? 'selected' : '' }}>Sélection</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input @error('obligatoire') is-invalid @enderror" id="obligatoire" name="obligatoire" value="1" {{ (old('obligatoire', $factureChamp->obligatoire ?? 0)) ? 'checked' : '' }}>
                            <label class="form-check-label" for="obligatoire">Obligatoire</label>
                            @error('obligatoire')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="ordre" class="form-label">Ordre d'affichage</label>
                            <input type="number" class="form-control @error('ordre') is-invalid @enderror" id="ordre" name="ordre" value="{{ old('ordre', $factureChamp->ordre ?? 0) }}" min="0">
                            @error('ordre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="2">{{ old('description', $factureChamp->description ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            {{ isset($factureChamp) ? 'Modifier' : 'Créer' }}
                        </button>
                        <a href="{{ route('admin.facture-champs.index') }}" class="btn btn-secondary">Annuler</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection