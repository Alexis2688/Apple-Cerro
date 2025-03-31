<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprasTable extends Migration
{

    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->string('modelo');
            $table->string('proveedor');
            $table->integer('cantidad');
            $table->decimal('precio', 8, 2);
            $table->string('estado');
            $table->date('fecha');  // Asegúrate de tener esta columna
            $table->text('notas')->nullable();
            $table->decimal('total', 8, 2);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('compras');
    }
}
