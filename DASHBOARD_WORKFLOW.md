# Documentation du Workflow du Dashboard

## Présentation

Le dashboard principal du système de gestion de facturation contient cinq boutons principaux qui correspondent exactement au workflow demandé :

```
Connexion utilisateur → Dashboard → Boutons :
├── Mon Entreprise → Accès aux données de l'émetteur
├── Mes Documents → Accès aux factures
├── Mes Clients → Accès à la gestion des clients
├── Paramètres Factures → Accès aux paramètres de facturation
└── Champs Factures → Accès à la configuration des champs
```

## Description des Boutons

### 1. "Mon Entreprise"
- **Route**: `/emetteurs`
- **Contrôleur**: `EmetteurController`
- **Fonction**: Permet de gérer les informations de l'entreprise émettrice (nom, adresse, logo, coordonnées bancaires, etc.)
- **Modèle**: `Emetteur`

### 2. "Mes Documents"
- **Route**: `/factures`
- **Contrôleur**: `FactureController`
- **Fonction**: Permet de créer, consulter, modifier et supprimer les factures
- **Modèle**: `Facture`

### 3. "Mes Clients"
- **Route**: `/clients`
- **Contrôleur**: `ClientController`
- **Fonction**: Permet de gérer les informations des clients
- **Modèle**: `Client`

### 4. "Paramètres Factures"
- **Route**: `/facture-parametres`
- **Contrôleur**: `FactureParametreController`
- **Fonction**: Permet de configurer les paramètres généraux de facturation
- **Modèle**: `FactureParametre`

### 5. "Champs Factures"
- **Route**: `/admin/facture-champs`
- **Contrôleur**: `FactureChampController`
- **Fonction**: Permet de configurer quels champs sont requis ou optionnels dans les factures
- **Modèle**: `FactureChamp`

## Intégration dans le Dashboard

Le code HTML pour ces boutons dans le dashboard (`/resources/views/dashboard.blade.php`) est :

```html
<div class="d-grid gap-2">
    <!-- Mon Entreprise (Émetteurs) -->
    <a href="{{ route('emetteurs.index') }}" class="btn-glass btn-primary-glass">
        <i class="fas fa-building mr-2"></i> Mon Entreprise
    </a>
    
    <!-- Mes Documents (Factures) -->
    <a href="{{ route('factures.index') }}" class="btn-glass">
        <i class="fas fa-file-invoice mr-2"></i> Mes Documents
    </a>
    
    <!-- Mes Clients -->
    <a href="{{ route('clients.index') }}" class="btn-glass">
        <i class="fas fa-users mr-2"></i> Mes Clients
    </a>
    
    <!-- Paramètres Factures -->
    <a href="{{ route('facture-parametres.index') }}" class="btn-glass">
        <i class="fas fa-cogs mr-2"></i> Paramètres Factures
    </a>
    
    <!-- Champs Factures -->
    <a href="{{ route('admin.facture-champs.index') }}" class="btn-glass">
        <i class="fas fa-edit mr-2"></i> Champs Factures
    </a>
</div>
```

## Avantages du Système

- **Navigation intuitive**: Les boutons sont clairement organisés selon le workflow utilisateur
- **Accès rapide**: Toutes les fonctionnalités principales sont accessibles en un clic depuis le dashboard
- **Conformité au workflow**: Le système respecte exactement le flux demandé
- **Interface utilisateur moderne**: Design en vitrail avec effets de transparence