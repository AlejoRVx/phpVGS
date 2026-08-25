<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('Pedidos', function (Blueprint $table) {
            $table->string('nombre_cliente', 255)->nullable()->after('total');
        });

        DB::table('Pedidos')
            ->join('Usuarios', 'Pedidos.usuario_id', '=', 'Usuarios.id')
            ->whereNull('Pedidos.nombre_cliente')
            ->update(['Pedidos.nombre_cliente' => DB::raw('Usuarios.nombre')]);
    }

    public function down(): void
    {
        Schema::table('Pedidos', function (Blueprint $table) {
            $table->dropColumn('nombre_cliente');
        });
    }
};
