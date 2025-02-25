<?php

namespace Modules\Club\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcademicPeriodStoreRequest extends FormRequest
{
    /**
     * Validations rules applied to the request
     * @return array
     * 
     * @OA\Schema(
     *  schema="AcademicPeriodStoreRequest",
     *  type="object",
     *  @OA\Property(title="Academic Year", property="academic_year_id", description="academic year associate", type="integer", example="1"),
     *  @OA\Property(title="Title", property="title", description="title of the academic year", type="string", example="Year 2022"), 
     *  @OA\Property(title="Start Date", property="start_date", description="starting's date of the academic year", type="string", example="2022-05-20"),
     *  @OA\Property(title="End Date", property="end_date", description="ending's date of the academic year", type="string", example="2022-05-30"),
     * )
     */
    public function rules()
    {
        return [
            'title'   => 'required|max:255',
            'start_date'   => 'required|date_format:Y-m-d',
            'end_date'   => 'required|date_format:Y-m-d'
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
