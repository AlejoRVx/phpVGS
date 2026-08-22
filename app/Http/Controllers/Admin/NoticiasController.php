<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Noticias;
use App\Services\Noticias\NoticiaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NoticiasController extends Controller
{
    public function __construct(private NoticiaService $noticias) {}

    public function index(): View
    {
        $noticias = $this->noticias->listar();

        return view('admin.noticias.index', compact('noticias'));
    }

    public function create(): View
    {
        return view('admin.noticias.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'resumen' => 'required|string|max:500',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'categoria' => 'required|string|max:100',
            'enlace' => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('noticias', 'public');
        } else {
            unset($validated['imagen']);
        }

        Noticias::create($validated);

        return redirect()->route('admin.noticias.index')
            ->with('success', 'Noticia creada correctamente');
    }

    public function edit(int $id): View
    {
        $noticia = $this->noticias->obtener($id);

        return view('admin.noticias.edit', compact('noticia'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $noticia = $this->noticias->obtener($id);

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'resumen' => 'required|string|max:500',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'categoria' => 'required|string|max:100',
            'enlace' => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('noticias', 'public');
        } else {
            unset($validated['imagen']);
        }

        $noticia->update($validated);

        return redirect()->route('admin.noticias.index')
            ->with('success', 'Noticia actualizada correctamente');
    }

    public function destroy(int $id): RedirectResponse
    {
        $noticia = $this->noticias->obtener($id);

        $this->noticias->eliminar($noticia);

        return back()->with('success', 'Noticia eliminada');
    }
}
