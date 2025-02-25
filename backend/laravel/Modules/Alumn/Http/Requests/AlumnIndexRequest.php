<?php

namespace Modules\Alumn\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Modules\Classroom\Rules\ValidClassroomAcademicYear;

class AlumnIndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'classroom_academic_year_id' => ['exists:classroom_academic_years,id', new ValidClassroomAcademicYear],
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
