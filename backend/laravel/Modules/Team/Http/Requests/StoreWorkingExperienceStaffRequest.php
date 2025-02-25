<?php

namespace Modules\Team\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkingExperienceStaffRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *   schema="StoreWorkingExperienceStaffRequest",
     *   @OA\Property( title="Experiences", property="experiences", description="experiences by staff", format="array", example="[{'club' :'asdasd','position_staff_id':3,'start_date': '2020-07-19','finish_date':'2020-07-19'},{'club' :'ashanm 2','position_staff_id':3,'start_date': '1994-07-19','finish_date':'2020-07-19'}]" ),
     * * )
     */
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'experiences'  => 'required|array',
            'experiences.*.club' => 'required|string',
            'experiences.*.position_staff_id' => 'required|integer|exists:position_staff,id',
            'experiences.*.start_date' => 'required|date',
            'experiences.*.finish_date' => 'required|date',
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
