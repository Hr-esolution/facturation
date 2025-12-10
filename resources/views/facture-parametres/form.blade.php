@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>{{ isset($factureParametre) ? 'Modifier Paramètre' : 'Créer Paramètre' }}</h4>
                </div>
                
                <div class="card-body">
                    <form action="{{ isset($factureParametre) ? route('facture-parametres.update', $factureParametre->id) : route('facture-parametres.store') }}" method="POST">
                        @csrf
                        @if(isset($factureParametre))
                            @method('PUT')
                        @endif
                        
                        <div class="mb-3">
                            <label for="cle" class="form-label">Clef</label>
                            <input type="text" class="form-control @error('cle') is-invalid @enderror" id="cle" name="cle" value="{{ old('cle', $factureParametre->cle ?? '') }}" required>
                            @error('cle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="valeur" class="form-label">Valeur</label>
                            <input type="text" class="form-control @error('valeur') is-invalid @enderror" id="valeur" name="valeur" value="{{ old('valeur', $factureParametre->valeur ?? '') }}" required>
                            @error('valeur')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="pays" class="form-label">Pays</label>
                            <select class="form-control @error('pays') is-invalid @enderror" id="pays" name="pays" required>
                                <option value="">Sélectionnez un pays</option>
                                <option value="FR" {{ (old('pays', $factureParametre->pays ?? '')) == 'FR' ? 'selected' : '' }}>France</option>
                                <option value="MA" {{ (old('pays', $factureParametre->pays ?? '')) == 'MA' ? 'selected' : '' }}>Maroc</option>
                                <option value="CA" {{ (old('pays', $factureParametre->pays ?? '')) == 'CA' ? 'selected' : '' }}>Canada</option>
                                <option value="BE" {{ (old('pays', $factureParametre->pays ?? '')) == 'BE' ? 'selected' : '' }}>Belgique</option>
                                <option value="CH" {{ (old('pays', $factureParametre->pays ?? '')) == 'CH' ? 'selected' : '' }}>Suisse</option>
                            </select>
                            @error('pays')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $factureParametre->description ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            {{ isset($factureParametre) ? 'Modifier' : 'Créer' }}
                        </button>
                        <a href="{{ route('facture-parametres.index') }}" class="btn btn-secondary">Annuler</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection