<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interventions', function (Blueprint $table) {
            $table->id();

            // Référence correcte sur la table clients
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');

            // technician_id reste sur users
            $table->foreignId('technician_id')->nullable()->constrained('users')->onDelete('set null');

            $table->text('description');
            $table->text('notes')->nullable();
            $table->string('device_type');
            $table->string('priority');
            $table->string('status');
            $table->datetime('scheduled_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interventions');
    }
};
