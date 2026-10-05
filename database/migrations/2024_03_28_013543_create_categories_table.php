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
        //10/04: Migración renombrada
        Schema::create('categories', function (Blueprint $table) {
            //Atributos de la tabla categorias
            $table->id('id');
            $table->string('nameCategory');
            $table->string('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories'); //Borrará la tabla si es que existe al momento de crear la migración.
    }
};
