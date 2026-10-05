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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            
            $table->date('oldMaintenanceDate');
            $table->date('maintenanceDate');
            $table->text('maintenanceDescription');
            
            //Atributo de la llave foranea para tabla elements
            $table->unsignedBigInteger('element_id');
            $table->timestamps();

            
            //Declaracion llaves foraneas
            $table->foreign('element_id')->references('id')->on('elements')->onDelete('cascade'); //Llave foranea
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
