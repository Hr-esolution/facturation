# Système MVC Complet - Workflow Dashboard

## Vue d'ensemble

Ce système Laravel implémente un workflow complet de gestion de facturation avec une architecture MVC bien structurée. Le workflow principal suit cette séquence :

**Connexion utilisateur → Dashboard → Boutons : Mon Entreprise (Émetteurs), Mes Documents (Factures), Mes Clients, Paramètres Factures, Champs Factures**

## Structure MVC

### Modèles (Models)
- **User** (`app/Models/User.php`) - Gestion des utilisateurs
- **Emetteur** (`app/Models/Emetteur.php`) - Gestion des émetteurs de données
- **Client** (`app/Models/Client.php`) - Gestion des clients
- **Facture** (`app/Models/Facture.php`) - Gestion des factures
- **FactureParametre** (`app/Models/FactureParametre.php`) - Configuration des paramètres de facturation
- **FactureTemplate** (`app/Models/FactureTemplate.php`) - Templates de factures
- **FactureChamp** (`app/Models/FactureChamp.php`) - Configuration des champs de factures

### Contrôleurs (Controllers)
- **EmetteurController** (`app/Http/Controllers/EmetteurController.php`) - CRUD pour émetteurs
- **ClientController** (`app/Http/Controllers/ClientController.php`) - CRUD pour clients
- **FactureController** (`app/Http/Controllers/FactureController.php`) - CRUD pour factures
- **FactureParametreController** (`app/Http/Controllers/FactureParametreController.php`) - CRUD pour paramètres factures
- **FactureTemplateController** (`app/Http/Controllers/Admin/FactureTemplateController.php`) - CRUD pour templates factures
- **FactureChampController** (`app/Http/Controllers/Admin/FactureChampController.php`) - CRUD pour champs factures

### Vues (Views)
#### Dashboard
- `resources/views/dashboard.blade.php` - Page principale avec tous les boutons du workflow

#### Émetteurs
- `resources/views/emetteurs/index.blade.php` - Liste des émetteurs

#### Clients
- `resources/views/clients/index.blade.php` - Liste des clients

#### Factures
- `resources/views/factures/index.blade.php` - Liste des factures
- `resources/views/factures/create.blade.php` - Formulaire de création
- `resources/views/factures/edit.blade.php` - Formulaire d'édition
- `resources/views/factures/show.blade.php` - Détails d'une facture

#### Paramètres Factures
- `resources/views/facture-parametres/index.blade.php` - Liste des paramètres
- `resources/views/facture-parametres/create.blade.php` - Formulaire de création
- `resources/views/facture-parametres/edit.blade.php` - Formulaire d'édition

#### Champs Factures (Admin)
- `resources/views/admin/facture-champs/index.blade.php` - Liste des champs
- `resources/views/admin/facture-champs/create.blade.php` - Formulaire de création
- `resources/views/admin/facture-champs/edit.blade.php` - Formulaire d'édition

#### Templates Factures (Admin)
- `resources/views/admin/facture-templates/index.blade.php` - Liste des templates
- `resources/views/admin/facture-templates/create.blade.php` - Formulaire de création
- `resources/views/admin/facture-templates/edit.blade.php` - Formulaire d'édition

### Routes (Routes)
- `routes/web.php` - Toutes les routes sont définies avec middleware auth

#### Routes principales :
- `/emetteurs` - Gestion des émetteurs
- `/clients` - Gestion des clients
- `/factures` - Gestion des factures
- `/facture-parametres` - Gestion des paramètres factures
- `/admin/facture-champs` - Gestion des champs factures
- `/admin/facture-templates` - Gestion des templates factures

### Migrations
- `database/migrations/2024_01_01_000001_create_facture_parametres_table.php` - Table des paramètres
- `database/migrations/2024_01_01_000002_create_facture_templates_table.php` - Table des templates
- `database/migrations/2024_01_01_000003_create_facture_champs_table.php` - Table des champs
- `database/migrations/2024_01_01_000004_create_emetteurs_table.php` - Table des émetteurs
- `database/migrations/2024_01_01_000005_create_clients_table.php` - Table des clients
- `database/migrations/2024_01_01_000006_create_factures_table.php` - Table des factures

## Fonctionnalités du Workflow

### 1. Mon Entreprise (Émetteurs)
- Gestion des émetteurs de données (personnes ou entreprises qui émettent des factures)
- CRUD complet pour gérer les informations de l'entreprise émettrice

### 2. Mes Documents (Factures)
- Gestion complète des factures
- Création, modification, visualisation et suppression
- Génération PDF et envoi par email

### 3. Mes Clients
- Gestion des clients
- Informations de contact et détails des clients

### 4. Paramètres Factures
- Configuration des paramètres spécifiques aux factures
- Paramètres par pays pour la conformité locale

### 5. Champs Factures
- Configuration des champs personnalisables dans les factures
- Gestion des types de champs, ordre d'affichage, obligation

## Design et Interface
- Interface moderne avec effet glass morphism
- Responsive design pour tous les appareils
- Graphiques interactifs avec Chart.js
- Palette de couleurs Pantone 2025

## Sécurité
- Authentification Laravel intégrée
- Middleware d'authentification sur toutes les routes sensibles
- Validation des données entrantes

## Services Utilisés
- `app/Services/FactureService.php` - Gestion avancée des factures
- `app/Services/PDFService.php` - Génération des PDF
- `app/Services/EmailService.php` - Envoi des emails
- `app/Services/QRCodeService.php` - Génération des QR codes
- `app/Services/SignatureService.php` - Gestion des signatures
- `app/Services/IAService.php` - Intelligence artificielle pour la reconnaissance de documents

## Installation

1. Cloner le dépôt
2. Exécuter `composer install`
3. Configurer le fichier `.env`
4. Exécuter `php artisan migrate`
5. Lancer avec `php artisan serve`

Le système est maintenant complet et opérationnel avec tous les composants MVC pour le workflow demandé.