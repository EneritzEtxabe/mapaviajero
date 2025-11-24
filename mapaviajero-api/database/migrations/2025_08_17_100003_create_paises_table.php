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
        Schema::create('paises', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->foreignId('continente_id')->constrained('continentes')->onDelete('cascade');
            $table->string('capital')->unique();
            $table->string('bandera_url')->nullable()->unique();
            $table->enum('conduccion', ['izquierda', 'derecha'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paises');
    }
};
