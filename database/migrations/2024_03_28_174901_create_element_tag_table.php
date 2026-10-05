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
        Schema::create('element_tag', function (Blueprint $table) {
            $table->id();
//10/04: Migración renombrada

            //NOTA: El metodo del seeder tags()->attach automáticamente hace la busqueda de las variables con el nombre element_idElement y su equivalnete en tag unicamente, se debe tener precaución con eso a la hora de nombrar las variables.
            ///NOTA: atributos de llave foranea renombradas a "<tabla/relacion>_id" para seguir convención de Laravel///
            $table->unsignedBigInteger('element_id');
            $table->unsignedBigInteger('tag_id');
            //Esta tabla actuara para la relacion muchos a muchos, por eso solo tiene referencias a llaves foraneas


            //Declaracion llaves foraneas
            $table->foreign('element_id')->references('id')->on('elements')->onDelete('cascade'); //Llave foranea
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('element_tag');
    }
};
