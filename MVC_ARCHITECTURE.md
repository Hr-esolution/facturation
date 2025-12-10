# Architecture MVC du Système de Facturation

## Vue d'Ensemble

```
┌─────────────────┐    ┌──────────────────┐    ┌──────────────────┐
│    MODELS       │    │   CONTROLLERS    │    │      VIEWS       │
│                 │    │                  │    │                  │
│  Client.php     │◄──►│ ClientController │◄──►│  clients/        │
│  Emetteur.php   │◄──►│ EmetteurController│◄──►│  emetteurs/      │
│  Facture.php    │◄──►│ FactureController │◄──►│  factures/       │
│  FactureParametre│◄──►│ FactureParametre │◄──►│  facture-parametres/│
│  FactureTemplate│◄──►│ FactureTemplate  │◄──→│  admin/          │
│     .php        │    │ Controller       │    │    facture-champs/│
│                 │    │                  │    │    facture-templates/│
│                 │    │                  │    │  dashboard.blade.php│
└─────────────────┘    └──────────────────┘    └──────────────────┘
         ▲                       ▲                        ▲
         │                       │                        │
         └───────────────────────┼────────────────────────┘
                                 │
                    ┌──────────────────┐
                    │    SERVICES      │
                    │                  │
                    │ FactureService   │
                    │ PDFService       │
                    │ EmailService     │
                    │ ...              │
                    └──────────────────┘
```

## Détail des Composants

### Modèles (Models)
- **Client**: Représente les clients du système
- **Emetteur**: Représente l'entreprise émettrice des factures
- **Facture**: Représente les factures générées
- **FactureParametre**: Stocke les paramètres de configuration
- **FactureTemplate**: Gère les modèles de factures

### Contrôleurs (Controllers)
- **ClientController**: Gère toutes les opérations liées aux clients
- **EmetteurController**: Gère les données de l'entreprise émettrice
- **FactureController**: Gère la création, modification, suppression des factures
- **FactureParametreController**: Gère les paramètres de facturation
- **FactureChampController**: Gère la configuration des champs de facture
- **FactureTemplateController**: Gère les modèles de factures

### Vues (Views)
- **Dashboard**: Interface principale avec les boutons du workflow
- **Clients**: Ensemble de vues pour la gestion des clients
- **Emetteurs**: Ensemble de vues pour la gestion des données de l'entreprise
- **Factures**: Ensemble de vues pour la gestion des factures
- **Paramètres**: Vues pour la configuration des paramètres
- **Champs**: Vues pour la configuration des champs de facture

## Flux de Données

```
Utilisateur → Vue → Contrôleur → Modèle → Base de données
    ↑           ↓        ↓           ↓
Résultat ← Vues ← Données ← Récupération ← Stockage
```

## Services

Les services encapsulent la logique métier complexe :

- **FactureService**: Gestion avancée des factures
- **PDFService**: Génération des documents PDF
- **EmailService**: Envoi des factures par email
- **SignatureService**: Gestion des signatures numériques

## Avantages de cette Architecture

1. **Séparation des préoccupations**: Chaque couche a un rôle clair
2. **Maintenabilité**: Modifications faciles sans impact sur d'autres parties
3. **Testabilité**: Chaque composant peut être testé indépendamment
4. **Extensibilité**: Ajout facile de nouvelles fonctionnalités
5. **Collaboration**: Différentes équipes peuvent travailler sur différentes couches