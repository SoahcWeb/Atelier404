<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            // $table->string('name', 100);
            // $table->string('email', 150)->unique();
            $table->string('phone', 20)->nullable();
            $table->string('address', 200)->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // admin ou technicien qui crée le client
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
