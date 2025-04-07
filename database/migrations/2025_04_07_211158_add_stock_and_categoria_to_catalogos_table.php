<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('catalogos', function (Blueprint $table) {
        
        $table->string('categoria')->nullable()->after('stock');
    });
}

public function down()
{
    Schema::table('catalogos', function (Blueprint $table) {
        $table->dropColumn(['stock', 'categoria']);
    });
}
};
