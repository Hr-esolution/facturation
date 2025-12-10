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
        Schema::create('facture_templates', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique(); // nom technique du template
            $table->string('titre'); // titre affiché
            $table->text('description')->nullable();
            $table->longText('contenu'); // contenu du template Blade
            $table->string('pays_concerne')->nullable(); // pays concerné par le template
            $table->boolean('est_actif')->default(true);
            $table->boolean('est_par_defaut')->default(false);
            $table->json('parametres')->nullable(); // paramètres spécifiques au template
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facture_templates');
    }
};