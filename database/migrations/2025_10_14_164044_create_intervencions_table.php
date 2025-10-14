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
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('technician_id')->nullable();
            $table->text('description');
            $table->string('device_type');
            $table->string('priority');
            $table->string('status');
            $table->datetime('scheduled_at')->nullable();
            $table->datetime("created_at");
            $table->datetime("update_at");
            $table->timestamps();

            $table->foreign('client_id')
                  ->references('id')
                  ->on('clients')
                  ->onDelete('cascade');

            $table->foreign('technician_id')
                  ->references('id')
                  ->on('technicians')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intervencions');
    }
};
