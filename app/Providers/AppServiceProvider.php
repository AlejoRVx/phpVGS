<?php

namespace App\Providers;

use App\Domain\Cart\CartManager;
use App\Domain\Contracts\UserNotifier;
use App\Repositories\NoticiaRepository;
use App\Repositories\PedidoRepository;
use App\Repositories\ProductoRepository;
use App\Repositories\ResenaRepository;
use App\Repositories\UsuarioRepository;
use App\Services\Admin\DashboardService;
use App\Services\Catalogo\AdminProductosService;
use App\Services\Catalogo\CatalogoService;
use App\Services\Noticias\NoticiaService;
use App\Services\Notifications\N8nUserNotifier;
use App\Services\Pedidos\CheckoutService;
use App\Services\Resenas\ResenaService;
use App\Services\Usuarios\RecuperacionClaveService;
use App\Services\Usuarios\UsuarioService;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // ─── Contratos (DIP) ───────────────────────────────
        $this->app->bind(UserNotifier::class, N8nUserNotifier::class);

        // ─── Repositorios (concretos, agrupados por contexto) ─
        $this->app->singleton(ProductoRepository::class);
        $this->app->singleton(UsuarioRepository::class);
        $this->app->singleton(PedidoRepository::class);
        $this->app->singleton(ResenaRepository::class);
        $this->app->singleton(NoticiaRepository::class);

        // ─── Servicios de dominio ───────────────────────────
        $this->app->singleton(CartManager::class);

        // ─── Servicios de aplicación ────────────────────────
        $this->app->singleton(CatalogoService::class);
        $this->app->singleton(AdminProductosService::class);
        $this->app->singleton(ResenaService::class);
        $this->app->singleton(UsuarioService::class);
        $this->app->singleton(RecuperacionClaveService::class);
        $this->app->singleton(CheckoutService::class);
        $this->app->singleton(DashboardService::class);
        $this->app->singleton(NoticiaService::class);
    }

    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
