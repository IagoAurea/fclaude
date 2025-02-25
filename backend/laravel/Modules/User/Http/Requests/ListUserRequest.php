<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListUserRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Permitir que todos los usuarios hagan esta solicitud.
    }

    public function rules()
    {
        return [
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:100',
        ];
    }

    public function messages()
    {
        return [
            'page.integer' => 'El número de página debe ser un número entero.',
            'page.min' => 'El número de página debe ser al menos 1.',
            'per_page.integer' => 'El número de elementos por página debe ser un número entero.',
            'per_page.min' => 'El número de elementos por página debe ser al menos 1.',
            'per_page.max' => 'El número de elementos por página no puede ser más de 100.',
        ];
    }
}
