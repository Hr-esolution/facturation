@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4>Paramètres du système</h4>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Signature Section -->
                    <div class="mb-5">
                        <h5>Signature électronique</h5>
                        <form action="{{ route('settings.update.signature') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="signature" class="form-label">Signature</label>
                                <textarea class="form-control @error('signature') is-invalid @enderror" id="signature" name="signature" rows="3" placeholder="Entrez votre signature ici...">{{ $signature ? $signature->valeur['signature'] ?? '' : '' }}</textarea>
                                @error('signature')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Enregistrer la signature</button>
                        </form>
                    </div>

                    <hr>

                    <!-- Email de partage Section -->
                    <div class="mb-5">
                        <h5>Email de partage</h5>
                        <form action="{{ route('settings.update.email-partage') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email pour l'envoi des factures</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $emailPartage ? $emailPartage->valeur['email'] ?? '' : '' }}" placeholder="email@exemple.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Enregistrer l'email</button>
                        </form>
                    </div>

                    <hr>

                    <!-- Logo Section -->
                    <div class="mb-5">
                        <h5>Logo</h5>
                        <form action="{{ route('settings.update.logo') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="logo" class="form-label">Télécharger un logo</label>
                                <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" accept="image/*">
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($logo && isset($logo->valeur['logo_path']))
                                    <div class="mt-2">
                                        <p>Logo actuel:</p>
                                        <img src="{{ asset('storage/' . $logo->valeur['logo_path']) }}" alt="Logo" style="max-width: 200px; max-height: 100px;">
                                    </div>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">Télécharger le logo</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection