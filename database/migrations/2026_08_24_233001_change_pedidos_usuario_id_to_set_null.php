<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->string('nombre_cliente', 255)->nullable()->after('total');
        });

        DB::table('pedidos')
            ->join('usuarios', 'pedidos.usuario_id', '=', 'usuarios.id')
            ->whereNull('pedidos.nombre_cliente')
            ->update(['pedidos.nombre_cliente' => DB::raw('usuarios.nombre')]);
    }

    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn('nombre_cliente');
        });
    }
};
