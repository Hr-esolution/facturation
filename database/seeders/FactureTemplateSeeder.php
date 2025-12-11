<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FactureTemplate;

class FactureTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default French invoice template
        FactureTemplate::factory()->create([
            'nom' => 'facture_francaise',
            'titre' => 'Facture Française',
            'description' => 'Modèle de facture conforme aux normes françaises',
            'contenu' => '<div class="invoice-template">
                            <h2>{{ entreprise.nom }}</h2>
                            <p><strong>Facture N°:</strong> {{ numero_facture }}</p>
                            <p><strong>Date:</strong> {{ date_facture }}</p>
                            <p><strong>Client:</strong> {{ client.prenom }} {{ client.nom }}</p>
                            <table class="invoice-table">
                                <thead>
                                    <tr>
                                        <th>Désignation</th>
                                        <th>Quantité</th>
                                        <th>Prix unitaire</th>
                                        <th>Total HT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Prestation de service</td>
                                        <td>1</td>
                                        <td>{{ montant_ht }} €</td>
                                        <td>{{ montant_ht }} €</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="invoice-totals">
                                <p>Total HT: {{ montant_ht }} €</p>
                                <p>TVA ({{ taux_tva }}%): {{ tva_montant }} €</p>
                                <p>Total TTC: {{ montant_ttc }} €</p>
                            </div>
                           </div>',
            'pays_concerne' => 'FR',
            'est_actif' => true,
            'est_par_defaut' => true,
        ]);

        // Create Canadian invoice template
        FactureTemplate::factory()->create([
            'nom' => 'facture_canadienne',
            'titre' => 'Facture Canadienne',
            'description' => 'Modèle de facture conforme aux normes canadiennes',
            'contenu' => '<div class="invoice-template">
                            <h2>{{ entreprise.nom }}</h2>
                            <p><strong>Invoice #:</strong> {{ numero_facture }}</p>
                            <p><strong>Date:</strong> {{ date_facture }}</p>
                            <p><strong>Client:</strong> {{ client.prenom }} {{ client.nom }}</p>
                            <table class="invoice-table">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Service rendered</td>
                                        <td>1</td>
                                        <td>${{ montant_ht }}</td>
                                        <td>${{ montant_ht }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="invoice-totals">
                                <p>Subtotal: ${{ montant_ht }}</p>
                                <p>Tax ({{ taux_tva }}%): ${{ tva_montant }}</p>
                                <p>Total: ${{ montant_ttc }}</p>
                            </div>
                           </div>',
            'pays_concerne' => 'CA',
            'est_actif' => true,
            'est_par_defaut' => false,
        ]);

        // Create Moroccan invoice template
        FactureTemplate::factory()->create([
            'nom' => 'facture_marocaine',
            'titre' => 'Facture Marocaine',
            'description' => 'Modèle de facture conforme aux normes marocaines',
            'contenu' => '<div class="invoice-template">
                            <h2>{{ entreprise.nom }}</h2>
                            <p><strong>Facture N°:</strong> {{ numero_facture }}</p>
                            <p><strong>Date:</strong> {{ date_facture }}</p>
                            <p><strong>Client:</strong> {{ client.prenom }} {{ client.nom }}</p>
                            <table class="invoice-table">
                                <thead>
                                    <tr>
                                        <th>Désignation</th>
                                        <th>Quantité</th>
                                        <th>Prix unitaire</th>
                                        <th>Total HT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Prestation de service</td>
                                        <td>1</td>
                                        <td>{{ montant_ht }} MAD</td>
                                        <td>{{ montant_ht }} MAD</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="invoice-totals">
                                <p>Total HT: {{ montant_ht }} MAD</p>
                                <p>TVA ({{ taux_tva }}%): {{ tva_montant }} MAD</p>
                                <p>Total TTC: {{ montant_ttc }} MAD</p>
                            </div>
                           </div>',
            'pays_concerne' => 'MA',
            'est_actif' => true,
            'est_par_defaut' => false,
        ]);

        // Create additional random templates
        FactureTemplate::factory(3)->create();
    }
}