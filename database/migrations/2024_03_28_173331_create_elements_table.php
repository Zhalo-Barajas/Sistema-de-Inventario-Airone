<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('elements', function (Blueprint $table) {
            ///NOTA: atributo "idElement" renombrado a "id" para seguir convención de Laravel ///
            $table->id('id');
            $table->text('nameElement'); //uso de variable tipo text para soportar mas de 255 caracteres
            $table->text('slug');
            $table->date('adquisitionDate');
            $table->enum('statusInv',[1,2])->default(1); //Columna que alojará un valor booleano Para identificar si el elemento del inventario está dado de alta o bja
            $table->date('maintenanceDate');
            $table->mediumtext('description')->nullable(); //Aumento de caracteres maximos.
            
            //Declaración de variables de llave foranea
            ///NOTA: atributos de llave foranea renombradas a "<tabla/relacion>_id" para seguir convención de Laravel///
            $table->unsignedBigInteger('ubication_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('fund_id');
            $table->unsignedBigInteger('building_id');

            //Declaracion de llaves foraneas
            $table->foreign('ubication_id')->references('id')->on('ubications')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('fund_id')->references('id')->on('funds')->onDelete('cascade');
            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
            
            //Referencias a tabla user predeterminada de laravel
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
           
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('elements');
    }
};
