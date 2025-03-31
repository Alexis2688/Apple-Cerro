<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('balances', function (Blueprint $table) {
            $table->id();
            $table->integer('month');
            $table->integer('year');
            $table->decimal('total_ventas', 12, 2)->default(0);
            $table->decimal('total_compras', 12, 2)->default(0);
            $table->decimal('total_reparaciones', 12, 2)->default(0);
            $table->decimal('ganancia_neta', 12, 2)->default(0);
            $table->timestamps();

            $table->unique(['month', 'year']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('balances');
    }
};
