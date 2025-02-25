<?php

namespace Modules\Club\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcademicYearStoreRequest extends FormRequest
{
    /**
     * Validations rules applied to the request
     * @return array
     * 
     * @OA\Schema(
     *  schema="AcademicYearStoreRequest",
     *  type="object",
     *  @OA\Property(title="Club", property="club_id", description="club associate", type="integer", example="1"), 
     *  @OA\Property(title="Title", property="title", description="title of the academic year", type="string", example="Year 2022"), 
     *  @OA\Property(title="Start Date", property="start_date", description="starting's date of the academic year", type="string", example="2022/05/20"), 
     *  @OA\Property(title="End Date", property="end_date", description="ending's date of the academic year", type="string", example="2022/05/30"), 
     *  @OA\Property(title="Is Active", property="is_active", description="the academic year is active or not", type="boolean", example="true"), 
     * )
     */
    public function rules()
    {
        return [
            'title'   => 'required|max:255',
            'start_date'   => 'required|date_format:Y/m/d',
            'end_date'   => 'required|date_format:Y/m/d',
            'is_active'   => 'required|boolean',
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
