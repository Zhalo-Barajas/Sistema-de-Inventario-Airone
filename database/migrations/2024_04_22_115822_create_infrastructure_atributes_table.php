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
        Schema::create('infrastructure_atributes', function (Blueprint $table) {
            $table->id();
            //Permitido que los valores sean nulos
            $table->string('material')->nullable();
            $table->string('dimensions')->nullable();
            $table->string('color')->nullable();
            $table->integer('quantity')->nullable();
            $table->timestamps();

            //Atributo de la llave foranea
            $table->unsignedBigInteger('element_id');

            //Declaracion llaves foraneas
            $table->foreign('element_id')->references('id')->on('elements')->onDelete('cascade'); //Llave foranea
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infrastructure_atributes');
    }
};
