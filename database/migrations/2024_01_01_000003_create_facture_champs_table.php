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
        Schema::create('facture_champs', function (Blueprint $table) {
            $table->id();
            $table->string('nom'); // nom du champ technique
            $table->string('label'); // libellé du champ
            $table->enum('type', ['text', 'number', 'select', 'date', 'textarea', 'checkbox', 'radio']);
            $table->string('pays'); // pays concerné par ce champ
            $table->boolean('est_requis')->default(false);
            $table->text('valeur_defaut')->nullable();
            $table->json('options')->nullable(); // options pour les champs select, radio, etc.
            $table->integer('ordre_affichage')->default(0);
            $table->string('groupe')->nullable(); // groupe auquel appartient le champ
            $table->json('regles_validation')->nullable(); // règles de validation spécifiques
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facture_champs');
    }
};