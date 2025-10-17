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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("intervention_id")->index();
            $table->text("path");
            $table->string("thumbnail_path");
            $table->datetime("created_at");
            $table->datetime("updated_at");
            $table->timestamps();

            $table->foreign('intervention_id')->references('id')->on('interventions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
