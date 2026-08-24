<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('Pedidos', function (Blueprint $table) {
            $table->dropForeign('Pedidos_usuario_id_foreign');
            $table->foreignId('usuario_id')->nullable()->change();
            $table->foreign('usuario_id')->references('id')->on('Usuarios')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('Pedidos', function (Blueprint $table) {
            $table->dropForeign('Pedidos_usuario_id_foreign');
            $table->foreignId('usuario_id')->nullable(false)->change();
            $table->foreign('usuario_id')->references('id')->on('Usuarios')->onDelete('cascade');
        });
    }
};
