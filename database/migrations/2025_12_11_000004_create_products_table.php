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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('categorie')->nullable();
            $table->string('designation');
            $table->text('description')->nullable();
            $table->decimal('prix_unitaire', 10, 2);
            $table->decimal('taxe', 5, 2)->default(0);
            $table->string('unite')->default('unité');
            $table->string('reference')->nullable();
            $table->string('code_barre')->nullable();
            $table->integer('stock')->default(0);
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};