<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->string('modelo');
            $table->string('estado');
            $table->decimal('precio_venta', 10, 2);
            $table->integer('cantidad')->default(1);
            $table->decimal('total', 10, 2); // O el tipo de dato adecuado
            $table->date('fecha')->default(now());
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ventas');
    }
};
