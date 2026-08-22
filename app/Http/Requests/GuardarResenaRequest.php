<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuardarResenaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|max:10000',
        ];
    }
}
