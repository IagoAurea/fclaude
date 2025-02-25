<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignPermissionsRequest extends FormRequest
{
    public function rules()
    {
        return [
            'userIds' => 'required|array',
            'userIds.*' => 'integer|exists:users,id', // Asegúrate de que el ID del usuario existe
            'permissions' => 'required|array',
      /*       'entityId' => 'required|integer',
            'entityType' => 'required|string', */
        ];
    }

    public function authorize()
    {
        return true; 
    }
}
