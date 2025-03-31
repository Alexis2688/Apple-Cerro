<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReparacionesTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reparaciones', function (Blueprint $table) {
            $table->id();
            $table->string('modelo');
            $table->string('fallas');
            $table->decimal('costo', 10, 2);  // Para el costo de la reparación
            $table->enum('estado', ['Reparado', 'En proceso', 'Pendiente']);  // Estado de la reparación
            $table->date('fecha');  // Fecha de la reparación
            $table->timestamps();  // Agrega las columnas created_at y updated_at
        });
    }

    /**
     * Revierte la migración.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reparaciones');
    }
}
