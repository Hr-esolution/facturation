<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->string('numero_facture')->unique();
            $table->unsignedBigInteger('emetteur_id');
            $table->unsignedBigInteger('client_id');
            $table->date('date_emission');
            $table->date('date_echeance');
            $table->json('produits');
            $table->decimal('total_ht', 15, 2)->default(0);
            $table->decimal('total_tva', 15, 2)->default(0);
            $table->decimal('total_ttc', 15, 2)->default(0);
            $table->string('statut')->default('brouillon'); // brouillon, envoyee, payee
            $table->string('mode_paiement')->nullable();
            $table->string('pays_client')->default('FR');
            $table->string('fichier_pdf')->nullable(); // Chemin vers le PDF généré
            $table->string('fichier_signature')->nullable(); // Chemin vers la signature
            $table->timestamp('date_paiement')->nullable(); // Date de paiement effective
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->foreign('emetteur_id')->references('id')->on('emetteurs')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};