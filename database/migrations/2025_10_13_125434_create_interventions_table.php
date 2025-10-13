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
        Schema::create('interventions', function (Blueprint $table) {
            $table->id();

            // Relations
            $table->foreignId('client_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete(); // équivalent à onDelete('set null') depuis Laravel 9

            // Données de l'intervention
            $table->text('description');
            $table->string('type_appareil', 100);

            // Champs enum basés sur les valeurs de tes Enums
            $table->enum('priorite', ['basse', 'normale', 'haute'])
                ->default('normale');

            $table->enum('statut', [
                'nouvelle',
                'diagnostic',
                'en_reparation',
                'termine',
                'non_reparable'
            ])->default('nouvelle');

            $table->date('date_prevue')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interventions');
    }
};
