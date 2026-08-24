<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropForeign('pedidos_usuario_id_foreign');
            $table->foreignId('usuario_id')->nullable()->change();
            $table->foreign('usuario_id')->references('id')->on('usuarios')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropForeign('pedidos_usuario_id_foreign');
            $table->foreignId('usuario_id')->nullable(false)->change();
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
        });
    }
};