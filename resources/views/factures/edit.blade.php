@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Modifier la facture #{{ $facture->numero_facture }}</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('factures.update', $facture->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="numero_facture" class="form-label">Numéro de facture</label>
                                    <input type="text" class="form-control @error('numero_facture') is-invalid @enderror" 
                                           id="numero_facture" name="numero_facture" value="{{ old('numero_facture', $facture->numero_facture) }}" required>
                                    @error('numero_facture')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="emetteur_id" class="form-label">Émetteur</label>
                                    <select class="form-control @error('emetteur_id') is-invalid @enderror" 
                                            id="emetteur_id" name="emetteur_id" required>
                                        <option value="">Sélectionnez un émetteur</option>
                                        <!-- Les émetteurs seront chargés dynamiquement -->
                                    </select>
                                    @error('emetteur_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="client_id" class="form-label">Client</label>
                                    <select class="form-control @error('client_id') is-invalid @enderror" 
                                            id="client_id" name="client_id" required>
                                        <option value="">Sélectionnez un client</option>
                                        <!-- Les clients seront chargés dynamiquement -->
                                    </select>
                                    @error('client_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date_emission" class="form-label">Date d'émission</label>
                                    <input type="date" class="form-control @error('date_emission') is-invalid @enderror" 
                                           id="date_emission" name="date_emission" value="{{ old('date_emission', $facture->date_emission->format('Y-m-d')) }}" required>
                                    @error('date_emission')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="date_echeance" class="form-label">Date d'échéance</label>
                                    <input type="date" class="form-control @error('date_echeance') is-invalid @enderror" 
                                           id="date_echeance" name="date_echeance" value="{{ old('date_echeance', $facture->date_echeance->format('Y-m-d')) }}" required>
                                    @error('date_echeance')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="pays_client" class="form-label">Pays du client</label>
                                    <select class="form-control @error('pays_client') is-invalid @enderror" 
                                            id="pays_client" name="pays_client" required>
                                        <option value="FR" {{ old('pays_client', $facture->pays_client) == 'FR' ? 'selected' : '' }}>France</option>
                                        <option value="MA" {{ old('pays_client', $facture->pays_client) == 'MA' ? 'selected' : '' }}>Maroc</option>
                                        <option value="EU" {{ old('pays_client', $facture->pays_client) == 'EU' ? 'selected' : '' }}>Union Européenne</option>
                                        <option value="CA" {{ old('pays_client', $facture->pays_client) == 'CA' ? 'selected' : '' }}>Canada</option>
                                        <option value="US" {{ old('pays_client', $facture->pays_client) == 'US' ? 'selected' : '' }}>États-Unis</option>
                                    </select>
                                    @error('pays_client')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Section des produits -->
                        <div class="mb-4">
                            <h5>Produits / Services</h5>
                            <div id="produits-container">
                                @foreach($facture->produits as $index => $produit)
                                    <div class="produit-row mb-3">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="produits[{{ $index }}][designation]" 
                                                       value="{{ $produit['designation'] }}" placeholder="Désignation" required>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" step="0.01" class="form-control" name="produits[{{ $index }}][quantite]" 
                                                       value="{{ $produit['quantite'] }}" placeholder="Quantité" required>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" step="0.01" class="form-control" name="produits[{{ $index }}][prix_unitaire]" 
                                                       value="{{ $produit['prix_unitaire'] }}" placeholder="Prix unitaire" required>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" step="0.01" class="form-control" name="produits[{{ $index }}][taux_tva]" 
                                                       value="{{ $produit['taux_tva'] }}" placeholder="TVA %" required>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-danger btn-sm remove-produit">Supprimer</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <button type="button" class="btn btn-secondary" id="add-produit">Ajouter un produit</button>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('factures.show', $facture->id) }}" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let produitIndex = {{ count($facture->produits) }};
    
    document.getElementById('add-produit').addEventListener('click', function() {
        const container = document.getElementById('produits-container');
        const newRow = document.createElement('div');
        newRow.className = 'produit-row mb-3';
        newRow.innerHTML = `
            <div class="row">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="produits[${produitIndex}][designation]" placeholder="Désignation" required>
                </div>
                <div class="col-md-2">
                    <input type="number" step="0.01" class="form-control" name="produits[${produitIndex}][quantite]" placeholder="Quantité" required>
                </div>
                <div class="col-md-2">
                    <input type="number" step="0.01" class="form-control" name="produits[${produitIndex}][prix_unitaire]" placeholder="Prix unitaire" required>
                </div>
                <div class="col-md-2">
                    <input type="number" step="0.01" class="form-control" name="produits[${produitIndex}][taux_tva]" placeholder="TVA %" value="20" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm remove-produit">Supprimer</button>
                </div>
            </div>
        `;
        container.appendChild(newRow);
        produitIndex++;
        
        // Ajouter l'événement de suppression pour le nouveau bouton
        newRow.querySelector('.remove-produit').addEventListener('click', function() {
            this.closest('.produit-row').remove();
        });
    });
    
    // Ajouter l'événement de suppression pour les boutons existants
    document.querySelectorAll('.remove-produit').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.produit-row').remove();
        });
    });
});
</script>
@endsection