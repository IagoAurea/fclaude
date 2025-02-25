<?php

namespace Modules\Tutorship\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Get the validation rules that apply to the request.
 * @return array
 * 
 *  @OA\Schema(
 *      schema="TutorshipRequest",
 *      @OA\Property(
 *          title="Date",
 *          property="date",
 *          description="Date of the tutorship",
 *          format="date",
 *          example="2022-02-20"
 *      ),
 *      @OA\Property(
 *          title="Tutor",
 *          property="teacher_id",
 *          description="Identifier representing the teacher who will be the tutor",
 *          format="string",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="Tutorship type",
 *          property="tutorship_type_id",
 *          description="Identifier representing the tutorship type who will be the tutor",
 *          format="string",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="Specialist referral",
 *          property="specialist_referral_id",
 *          description="Identifier representing the specialist referral",
 *          format="string",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="Alumn",
 *          property="alumn_id",
 *          description="Identifier representing the alumn",
 *          format="string",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="Reason",
 *          property="reason",
 *          description="String representing the reason of the tutorship",
 *          format="string",
 *          example="string"
 *      ),
 *      @OA\Property(
 *          title="Resume",
 *          property="resume",
 *          description="String representing a resume of the tutorship",
 *          format="string",
 *          example="string"
 *      ),
 *  )
 */
class TutorshipRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => 'required|date',
            'teacher_id' => 'numeric|required|exists:classroom_teachers,id',
            'tutorship_type_id' => 'numeric|required|exists:tutorship_types,id',
            'specialist_referral_id' => 'exists:specialist_referrals,id',
            'alumn_id' => 'required|exists:alumns,id',
            'resume' => 'max:1000',
            'reason' => 'max:1000'
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
