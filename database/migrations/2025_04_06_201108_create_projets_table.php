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
        Schema::create('projets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('titre');
            $table->text('description')->nullable();
            $table->enum('type', ['En Développement', 'En Création']);
            $table->enum('forme_juridique', [
                'PME & Startup',
                'Grandes Entreprises',
                'Administration Publiques',
                'Cabinets de Recrutement',
                'Organisme de Recrutement',
                'Structure Accompagnement'
            ]);
            $table->string('plan_affaire_path');
            $table->string('resume_path')->nullable();
            $table->enum('statut', ['En Attente', 'Validé', 'Rejeté'])->default('En Attente');
            $table->text('justification_rejet')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projets');
    }
};
