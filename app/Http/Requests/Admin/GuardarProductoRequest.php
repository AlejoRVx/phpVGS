<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class GuardarProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas compartidas por create y update; la imagen es
     * obligatoria al crear y opcional al editar.
     */
    public function rules(): array
    {
        $obligatoriaImagen = $this->isMethod('post') ? 'required' : 'nullable';

        return [
            'stock' => 'required|integer|min:0',
            'tipo' => 'required|string|in:Juego,Consola',
            'genero' => 'nullable|string|max:255',
            'nombre' => 'required|string|max:255',
            'compania' => 'required|string|max:255',
            'fecha_lanzamiento' => 'required|date',
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'required|string|max:1000',
            'imagen' => "{$obligatoriaImagen}|image|mimes:jpeg,png,jpg,gif,webp|max:8192",
        ];
    }
}
