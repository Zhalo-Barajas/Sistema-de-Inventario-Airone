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
        Schema::create('ubications', function (Blueprint $table) { //el comando lo nombro originalmente "ubicacions"
            ///NOTA: atributo "idUbication" renombrado a "id" para seguir convención de Laravel ///
            $table->id('id');
            $table->string('nameUbication');
            //$table->string('edificio',5);
            //$table->string('slug'); //Datos no utilizados
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ubications');
    }
};
