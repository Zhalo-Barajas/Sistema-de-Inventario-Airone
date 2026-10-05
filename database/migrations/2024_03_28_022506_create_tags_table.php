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
        Schema::create('tags', function (Blueprint $table) {
            ///NOTA: atributo "idTag" renombrado a "id" para seguir convención de Laravel ///
            $table->id('id');
            $table->string('nameTag');
            $table->string('slug');
            $table->string('color'); // Añadida columna color (Usada en parte frontend del sistema)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
