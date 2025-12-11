@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Produits</h4>
                    <a href="{{ route('products.create') }}" class="btn btn-primary">Nouveau Produit</a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Catégorie</th>
                                    <th>Désignation</th>
                                    <th>Prix Unitaire</th>
                                    <th>Stock</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $product->categorie ?? '-' }}</td>
                                        <td>{{ $product->designation }}</td>
                                        <td>{{ number_format($product->prix_unitaire, 2, ',', ' ') }} €</td>
                                        <td>{{ $product->stock }}</td>
                                        <td>
                                            <span class="badge {{ $product->actif ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $product->actif ? 'Actif' : 'Inactif' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-info">Voir</a>
                                                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">Modifier</a>
                                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">Supprimer</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Aucun produit trouvé</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection