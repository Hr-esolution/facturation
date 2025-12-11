@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Créer un nouveau produit</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="categorie" class="form-label">Catégorie</label>
                            <input type="text" class="form-control @error('categorie') is-invalid @enderror" id="categorie" name="categorie" value="{{ old('categorie') }}">
                            @error('categorie')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="designation" class="form-label">Désignation *</label>
                            <input type="text" class="form-control @error('designation') is-invalid @enderror" id="designation" name="designation" value="{{ old('designation') }}" required>
                            @error('designation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="prix_unitaire" class="form-label">Prix unitaire *</label>
                            <input type="number" step="0.01" class="form-control @error('prix_unitaire') is-invalid @enderror" id="prix_unitaire" name="prix_unitaire" value="{{ old('prix_unitaire') }}" required>
                            @error('prix_unitaire')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="taxe" class="form-label">Taxe (%)</label>
                            <input type="number" step="0.01" class="form-control @error('taxe') is-invalid @enderror" id="taxe" name="taxe" value="{{ old('taxe', 0) }}">
                            @error('taxe')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="unite" class="form-label">Unité</label>
                            <input type="text" class="form-control @error('unite') is-invalid @enderror" id="unite" name="unite" value="{{ old('unite', 'unité') }}">
                            @error('unite')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="reference" class="form-label">Référence</label>
                            <input type="text" class="form-control @error('reference') is-invalid @enderror" id="reference" name="reference" value="{{ old('reference') }}">
                            @error('reference')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="code_barre" class="form-label">Code-barres</label>
                            <input type="text" class="form-control @error('code_barre') is-invalid @enderror" id="code_barre" name="code_barre" value="{{ old('code_barre') }}">
                            @error('code_barre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', 0) }}">
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="actif" name="actif" value="1" {{ old('actif', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="actif">Actif</label>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('products.index') }}" class="btn btn-secondary me-md-2">Annuler</a>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection