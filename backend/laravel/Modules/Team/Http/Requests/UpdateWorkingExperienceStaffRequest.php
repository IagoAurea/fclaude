<?php

namespace Modules\Team\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkingExperienceStaffRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *   schema="UpdateWorkingExperienceStaffRequest",
     *   @OA\Property( title="Club", property="club", description="", format="string", example="Club" ),
     *   @OA\Property( title="Position", property="position_staff_id", description="", format="integer", example="1" ),
     *   @OA\Property( title="Start Date", property="start_date", description="", format="date", example="2021-11-20" ),
     *   @OA\Property( title="Finish Date", property="finish_date", description="", format="integer", example="2021-11-22" ),
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
            'club' => 'required|string',
            'position_staff_id' => 'required|integer|exists:position_staff,id',
            'start_date' => 'required|date',
            'finish_date' => 'required|date',
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
