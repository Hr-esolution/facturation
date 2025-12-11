@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Détails du produit: {{ $product->designation }}</h4>
                    <div>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">Retour</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Catégorie:</strong> {{ $product->categorie ?? '-' }}</p>
                            <p><strong>Désignation:</strong> {{ $product->designation }}</p>
                            <p><strong>Description:</strong> {{ $product->description ?? '-' }}</p>
                            <p><strong>Prix unitaire:</strong> {{ number_format($product->prix_unitaire, 2, ',', ' ') }} €</p>
                            <p><strong>Taxe:</strong> {{ $product->taxe }}%</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Unité:</strong> {{ $product->unite }}</p>
                            <p><strong>Référence:</strong> {{ $product->reference ?? '-' }}</p>
                            <p><strong>Code-barres:</strong> {{ $product->code_barre ?? '-' }}</p>
                            <p><strong>Stock:</strong> {{ $product->stock }}</p>
                            <p><strong>Statut:</strong> 
                                <span class="badge {{ $product->actif ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $product->actif ? 'Actif' : 'Inactif' }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection