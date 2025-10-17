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
            $table->string("name", 100);
            $table->string("first_name", 100);
            $table->string("email", 150)->unique();
            $table->string("phone", 20)->nullable();
            $table->string("address", 200)->nullable();
            $table->datetime("created_at")->nullable();
            $table->datetime("update_at")->nullable();
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
