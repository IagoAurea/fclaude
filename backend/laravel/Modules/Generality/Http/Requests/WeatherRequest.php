<?php


namespace Modules\Generality\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class WeatherRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'es' => 'required',
            'en' => 'required',
            'code' => 'required|string',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
