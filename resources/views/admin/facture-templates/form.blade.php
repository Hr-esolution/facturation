@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>{{ isset($factureTemplate) ? 'Modifier Template' : 'Créer Template' }}</h4>
                </div>
                
                <div class="card-body">
                    <form action="{{ isset($factureTemplate) ? route('admin.facture-templates.update', $factureTemplate->id) : route('admin.facture-templates.store') }}" method="POST">
                        @csrf
                        @if(isset($factureTemplate))
                            @method('PUT')
                        @endif
                        
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom', $factureTemplate->nom ?? '') }}" required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $factureTemplate->description ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="contenu_html" class="form-label">Contenu HTML</label>
                            <textarea class="form-control @error('contenu_html') is-invalid @enderror" id="contenu_html" name="contenu_html" rows="10">{{ old('contenu_html', $factureTemplate->contenu_html ?? '') }}</textarea>
                            @error('contenu_html')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="pays" class="form-label">Pays</label>
                            <select class="form-control @error('pays') is-invalid @enderror" id="pays" name="pays">
                                <option value="">Tous les pays</option>
                                <option value="FR" {{ (old('pays', $factureTemplate->pays ?? '')) == 'FR' ? 'selected' : '' }}>France</option>
                                <option value="MA" {{ (old('pays', $factureTemplate->pays ?? '')) == 'MA' ? 'selected' : '' }}>Maroc</option>
                                <option value="CA" {{ (old('pays', $factureTemplate->pays ?? '')) == 'CA' ? 'selected' : '' }}>Canada</option>
                                <option value="BE" {{ (old('pays', $factureTemplate->pays ?? '')) == 'BE' ? 'selected' : '' }}>Belgique</option>
                                <option value="CH" {{ (old('pays', $factureTemplate->pays ?? '')) == 'CH' ? 'selected' : '' }}>Suisse</option>
                            </select>
                            @error('pays')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input @error('statut') is-invalid @enderror" id="statut" name="statut" value="1" {{ (old('statut', $factureTemplate->statut ?? 1)) ? 'checked' : '' }}>
                            <label class="form-check-label" for="statut">Actif</label>
                            @error('statut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            {{ isset($factureTemplate) ? 'Modifier' : 'Créer' }}
                        </button>
                        <a href="{{ route('admin.facture-templates.index') }}" class="btn btn-secondary">Annuler</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection