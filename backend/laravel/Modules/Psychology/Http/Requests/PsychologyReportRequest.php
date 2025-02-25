<?php


namespace Modules\Psychology\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class PsychologyReportRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'player_id' => 'required|integer|exists:players,id',
            'psychology_specialist_id' => 'integer|exists:psychology_specialists,id',
            'staff_id' => 'required_without:staff_name|integer|exists:staff_users,id',
            'date' => 'required|date',
            'anamnesis' => 'nullable|string',
            'staff_name' => 'nullable|string',
            'note' => 'nullable|string',
            'cause' => 'required|string',
            'presumptive_diagnosis' => 'required|string',
            'team_id' => 'required|integer|exists:teams,id'
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
