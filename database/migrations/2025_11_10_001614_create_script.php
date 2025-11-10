<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('Roles', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
        });

        Schema::create('Usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('correo')->unique();
            $table->string('contrasena');
            $table->string('nombre');
            $table->string('direccion');
            $table->string('telefono');
            $table->foreignId('rol_id')->constrained('Roles');
        });

        Schema::create('Auditorias', function (Blueprint $table) {
            $table->id();
            $table->string('tabla');
            $table->string('accion');
            $table->string('cambios');
            $table->dateTime('fecha');
        });

        Schema::create('Productos', function (Blueprint $table) {
            $table->id();
            $table->integer('stock');
            $table->string('tipo');
            $table->string('genero');
            $table->string('nombre');
            $table->string('compania');
            $table->dateTime('fecha_lanzamiento');
            $table->decimal('precio', 8, 2);
            $table->string('descripcion');
            $table->string('imagen');
        });

        Schema::create('Resenas', function (Blueprint $table) {
            $table->id();
            $table->decimal('calificacion', 1, 1);
            $table->string('comentario');
            $table->dateTime('fecha');
            $table->foreignId('usuario_id')->constrained('Usuarios');
            $table->foreignId('producto_id')->constrained('Productos');
        });

        Schema::create('Pedidos', function (Blueprint $table) {
            $table->id();
            $table->decimal('total', 8, 2);
            $table->boolean('estado');
            $table->foreignId('usuario_id')->constrained('Usuarios');
        });

        Schema::create('Pedido_Productos', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 8, 2);
            $table->foreignId('pedido_id')->constrained('Pedidos');
            $table->foreignId('producto_id')->constrained('Productos');
            
        });

        Schema::create('Pagos', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_pago');
            $table->string('metodo');
            $table->decimal('total', 8, 2);
            $table->foreignId('pedido_id')->constrained('Pedidos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scripts');
    }
};
