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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->string('entreprise')->nullable();
            $table->json('adresse')->nullable();
            $table->string('ville')->nullable();
            $table->string('code_postal')->nullable();
            $table->string('pays')->default('FR');
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            
            // Champs spécifiques au Maroc
            $table->string('ice')->nullable();
            $table->string('if')->nullable();
            $table->string('rc')->nullable();
            $table->string('patente')->nullable();
            
            // Champs spécifiques à l'UE/FR
            $table->string('numero_tva_intracommunautaire')->nullable();
            $table->string('adresse_complete')->nullable();
            
            // Champs spécifiques au Canada
            $table->string('numero_gst_hst_qst')->nullable();
            $table->string('numero_enregistrement')->nullable();
            
            // Champs spécifiques aux États-Unis
            $table->string('ein')->nullable();
            $table->string('state_sales_tax')->nullable();
            $table->string('zip_code')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};