<?php

namespace App\Domain\Cart;

use App\Models\CarritoItem;
use App\Models\Productos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartManager
{
    public const SESSION_KEY = 'pedidos';

    private ?array $cachedItems = null;

    /**
     * @return array<int, array{id: int, nombre: string, precio: float, cantidad: int, imagen: string, tipo: string}>
     */
    public function items(): array
    {
        return $this->cachedItems ??= Session::get(self::SESSION_KEY, []);
    }

    public function isEmpty(): bool
    {
        return $this->items() === [];
    }

    public function total(): float
    {
        return (float) collect($this->items())->sum(
            fn (array $item) => $item['precio'] * $item['cantidad']
        );
    }

    public function totalItems(): int
    {
        return (int) array_sum(array_column($this->items(), 'cantidad'));
    }

    public function add(Productos $producto): void
    {
        $items = $this->items();

        if (isset($items[$producto->id])) {
            $items[$producto->id]['cantidad']++;
        } else {
            $items[$producto->id] = [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'cantidad' => 1,
                'imagen' => $producto->imagen,
                'tipo' => $producto->tipo,
            ];
        }

        $this->persist($items);

        if ($userId = Auth::id()) {
            CarritoItem::updateOrCreate(
                ['usuario_id' => $userId, 'producto_id' => $producto->id],
                ['cantidad' => $items[$producto->id]['cantidad']]
            );
        }
    }

    public function setQuantity(int $productoId, int $cantidad): void
    {
        if ($cantidad < 0) {
            return;
        }

        $items = $this->items();

        if (! isset($items[$productoId])) {
            return;
        }

        if ($cantidad === 0) {
            $this->remove($productoId);

            return;
        }

        if ($items[$productoId]['cantidad'] === $cantidad) {
            return;
        }

        $items[$productoId]['cantidad'] = $cantidad;
        $this->persist($items);

        if ($userId = Auth::id()) {
            CarritoItem::where('usuario_id', $userId)
                ->where('producto_id', $productoId)
                ->update(['cantidad' => $cantidad]);
        }
    }

    public function remove(int $productoId): void
    {
        $items = $this->items();
        unset($items[$productoId]);
        $this->persist($items);

        if ($userId = Auth::id()) {
            CarritoItem::where('usuario_id', $userId)
                ->where('producto_id', $productoId)
                ->delete();
        }
    }

    public function clear(): void
    {
        $this->cachedItems = [];
        Session::forget(self::SESSION_KEY);

        if ($userId = Auth::id()) {
            CarritoItem::where('usuario_id', $userId)->delete();
        }
    }

    /**
     * Reconstruye la sesión del carrito a partir de la persistencia en BD.
     * Se usa al iniciar sesión.
     */
    public function loadFromDatabase(int $userId): void
    {
        $items = [];

        CarritoItem::with('producto')
            ->where('usuario_id', $userId)
            ->get()
            ->each(function (CarritoItem $item) use (&$items) {
                $p = $item->producto;
                $items[$p->id] = [
                    'id' => $p->id,
                    'nombre' => $p->nombre,
                    'precio' => $p->precio,
                    'cantidad' => $item->cantidad,
                    'imagen' => $p->imagen,
                    'tipo' => $p->tipo,
                ];
            });

        $this->persist($items);
    }

    private function persist(array $items): void
    {
        $this->cachedItems = $items;
        Session::put(self::SESSION_KEY, $items);
    }
}
