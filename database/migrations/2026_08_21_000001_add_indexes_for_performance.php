<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table): void {
            $table->index('tipo');
            $table->index('nombre');
            $table->index('precio');
            $table->index('compania');
        });

        Schema::table('resenas', function (Blueprint $table): void {
            $table->index('producto_id');
            $table->index('usuario_id');
        });

        Schema::table('pedidos', function (Blueprint $table): void {
            $table->index('usuario_id');
            $table->index('created_at');
        });

        Schema::table('pagos', function (Blueprint $table): void {
            $table->index('pedido_id');
        });
    }

    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table): void {
            $table->dropIndex(['tipo']);
            $table->dropIndex(['nombre']);
            $table->dropIndex(['precio']);
            $table->dropIndex(['compania']);
        });

        Schema::table('resenas', function (Blueprint $table): void {
            $table->dropIndex(['producto_id']);
            $table->dropIndex(['usuario_id']);
        });

        Schema::table('pedidos', function (Blueprint $table): void {
            $table->dropIndex(['usuario_id']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('pagos', function (Blueprint $table): void {
            $table->dropIndex(['pedido_id']);
        });
    }
};
