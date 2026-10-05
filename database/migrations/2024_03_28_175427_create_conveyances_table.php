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
        Schema::create('conveyances', function (Blueprint $table) {
            ///NOTA: atributo "idConveyance" renombrado a "id" para seguir convención de Laravel ///
            $table->id('id');
            $table->date('conveyanceDate');


            //Declaración de variables de llave foranea
            $table->unsignedBigInteger('oldBuilding_id');
            $table->unsignedBigInteger('oldUbication_id');
            $table->unsignedBigInteger('ubication_id');
            $table->unsignedBigInteger('building_id');
            $table->unsignedBigInteger('element_id');
            
            // Existen oldBuilding tiene una llave foranea con la id de la tabla buildings.

            ////// Declaracion de llaves foraneas
            $table->foreign('oldBuilding_id')->references('id')->on('buildings')->onDelete('cascade');
            $table->foreign('Building_id')->references('id')->on('buildings')->onDelete('cascade');
            $table->foreign('ubication_id')->references('id')->on('ubications')->onDelete('cascade');
            $table->foreign('oldUbication_id')->references('id')->on('ubications')->onDelete('cascade');
            $table->foreign('element_id')->references('id')->on('elements')->onDelete('cascade');

            // //Declaracion de llaves foraneas
            // $table->foreign('idElement')->references('idElement')->on('elements')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conveyances');
    }
};