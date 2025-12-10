# Système de Gestion de Facturation - Architecture MVC

## Structure du Projet

Ce système de gestion de facturation suit une architecture Model-View-Controller (MVC) avec la structure suivante :

```
app/
├── Models/                 # Modèles de données
│   ├── Client.php         # Gestion des clients
│   ├── Emetteur.php       # Gestion des émetteurs (entreprise)
│   ├── Facture.php        # Gestion des factures
│   ├── FactureParametre.php # Paramètres de facturation
│   └── FactureTemplate.php # Modèles de factures
├── Http/
│   └── Controllers/       # Contrôleurs MVC
│       ├── ClientController.php      # Contrôleur des clients
│       ├── EmetteurController.php    # Contrôleur des émetteurs
│       ├── FactureController.php     # Contrôleur des factures
│       ├── FactureParametreController.php # Contrôleur des paramètres
│       └── Admin/
│           ├── FactureChampController.php    # Contrôleur des champs de facture
│           └── FactureTemplateController.php # Contrôleur des modèles
├── Services/              # Services métier
│   ├── FactureService.php # Service de gestion des factures
│   ├── PDFService.php     # Service de génération PDF
│   └── ...
resources/
└── views/                 # Vues du système
    ├── dashboard.blade.php # Tableau de bord principal
    ├── clients/           # Vues des clients
    ├── emetteurs/         # Vues des émetteurs
    ├── factures/          # Vues des factures
    └── admin/             # Vues administrateur
        ├── facture-champs/ # Vues des champs de facture
        └── facture-templates/ # Vues des modèles
routes/
└── web.php                # Définition des routes
```

## Workflow du Système

Le système implémente le workflow suivant :

```
Connexion utilisateur → Dashboard → Boutons :
├── Mon Entreprise (Émetteurs) → Gestion des données de l'entreprise
├── Mes Documents (Factures) → Gestion des factures
├── Mes Clients → Gestion des clients
├── Paramètres Factures → Configuration des paramètres de facturation
└── Champs Factures → Configuration des champs de facture
```

## Fonctionnalités

### 1. Mon Entreprise (Émetteurs)
- Gestion des informations de l'entreprise émettrice
- Configuration des détails de l'entreprise (nom, adresse, logo, etc.)

### 2. Mes Documents (Factures)
- Création, lecture, mise à jour et suppression de factures
- Génération de PDF
- Envoi par email
- Suivi des paiements

### 3. Mes Clients
- Gestion des informations client
- Ajout/modification/suppression de clients
- Historique des transactions

### 4. Paramètres Factures
- Configuration des paramètres globaux de facturation
- Paramètres spécifiques selon les pays
- Clés de configuration personnalisées

### 5. Champs Factures
- Configuration des champs obligatoires/optionnels
- Réorganisation des champs
- Adaptation selon les besoins locaux

## Routes Principales

- `/home` - Dashboard principal
- `/emetteurs` - Gestion des émetteurs
- `/factures` - Gestion des factures
- `/clients` - Gestion des clients
- `/facture-parametres` - Paramètres de facturation
- `/admin/facture-champs` - Configuration des champs
- `/admin/facture-templates` - Modèles de factures

## Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install && npm run dev
```

## Technologies Utilisées

- **Laravel** - Framework PHP MVC
- **Bootstrap** - Framework CSS
- **Chart.js** - Visualisation de données
- **MySQL** - Base de données
- **PDF Generation** - Pour les factures