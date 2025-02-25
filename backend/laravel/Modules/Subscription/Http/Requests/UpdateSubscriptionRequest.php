<?php

namespace Modules\Subscription\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubscriptionRequest extends FormRequest
{
    /**
     *  Get the validation rules that apply to the request.
     *  @return array
     *
     *  @OA\Schema(
     *      schema="UpdateSubscriptionRequest",
     *      type="object",
     *      @OA\Property(property="package_price_id", format="int64", example="1"),
     *      @OA\Property(property="interval", format="string",
     *          example="month", description="Type of interval, permitted value month or year"),
     *      @OA\Property(property="type", format="string",
     *          example="sport", description="Type of subscription, permitted value sport or teacher"),
     *      @OA\Property(property="sport", type="object",
     *          @OA\Property(property="clubs", type="boolean", example=true, description="Checkbox for Clubs"),
     *          @OA\Property(property="teams", type="array", @OA\Items(type="integer"), example="[1, 2]"),
     *          @OA\Property(property="competicion", type="boolean", example=true, description="Checkbox for Competición"),
     *          @OA\Property(property="matches", type="array", @OA\Items(type="integer"), example="[1, 2]"),
     *          @OA\Property(property="scouting", type="boolean", example=true, description="Checkbox for Scouting de partidos"),
     *          @OA\Property(property="exercises", type="array", @OA\Items(type="integer"), example="[1, 2]"),
     *          @OA\Property(property="exercise_sessions", type="array", @OA\Items(type="integer"), example="[1, 2]"),
     *          @OA\Property(property="players", type="array", @OA\Items(type="integer"), example="[1, 2]"),
     *          @OA\Property(property="tests", type="array", @OA\Items(type="integer"), example="[1, 2]"),
     *          @OA\Property(property="injuries_prevention", type="array", @OA\Items(type="integer"), example="[1, 2]"),
     *          @OA\Property(property="injuries_rfd", type="array", @OA\Items(type="integer"), example="[1, 2]"),
     *          @OA\Property(property="files_fisiotherapy", type="array", @OA\Items(type="integer"), example="[1, 2]"),
     *          @OA\Property(property="efforts_recovery", type="array", @OA\Items(type="integer"), example="[1, 2]"),
     *          @OA\Property(property="nutritional_sheets", type="array", @OA\Items(type="integer"), example="[1, 2]"),
     *          @OA\Property(property="psychology_reports", type="array", @OA\Items(type="integer"), example="[1, 2]")
     *      ),
     *      @OA\Property(property="teacher", type="object",
     *          @OA\Property(property="educational_center", type="array", @OA\Items(type="integer"), example="[1, 2]"),
     *          @OA\Property(property="classes", type="array", @OA\Items(type="integer"), example="[1, 2]"),
     *          @OA\Property(property="students", type="array", @OA\Items(type="integer"), example="[1, 2]"),
     *          @OA\Property(property="exercises", type="array", @OA\Items(type="integer"), example="[1, 2]"),
     *          @OA\Property(property="exercise_sessions", type="array", @OA\Items(type="integer"), example="[1, 2]"),
     *          @OA\Property(property="available_scenarios", type="array", @OA\Items(type="integer"), example="[1, 2]"),
     *          @OA\Property(property="tests", type="array", @OA\Items(type="integer"), example="[1, 2]"),
     *          @OA\Property(property="rubrics", type="array", @OA\Items(type="integer"), example="[1, 2]"),
     *          @OA\Property(property="evaluations", type="array", @OA\Items(type="integer"), example="[1, 2]"),
     *          @OA\Property(property="tutorships", type="array", @OA\Items(type="integer"), example="[1, 2]"),
     *          @OA\Property(property="grades", type="array", @OA\Items(type="integer"), example="[1, 2]")
     *      )
     * )
     */
    public function rules()
    {
        return [
            'package_price_id' => 'required|integer|exists:packages_price,id',
            'interval' => 'required|in:month,year',
            'type' => 'required|string|in:sport,teacher',
            // Sport rules
            'sport.clubs' => 'boolean',
            'sport.teams' => 'array',
            'sport.teams.*' => 'integer|exists:teams,id|min:0',
            'sport.competicion' => 'boolean',
            'sport.matches' => 'array',
            'sport.matches.*' => 'integer|exists:competition_matches,id|min:0',
            'sport.scouting' => 'boolean',
            'sport.exercises' => 'array',
            'sport.exercises.*' => 'integer|exists:exercises,id|min:0',
            'sport.exercise_sessions' => 'array',
            'sport.exercise_sessions.*' => 'integer|exists:exercise_sessions,id|min:0',
            'sport.players' => 'array',
            'sport.players.*' => 'integer|exists:players,id|min:0',
            'sport.tests' => 'array',
            'sport.tests.*' => 'integer|exists:test_applications,id|min:0',
            'sport.injuries_prevention' => 'array',
            'sport.injuries_prevention.*' => 'integer|exists:injury_preventions,id|min:0',
            'sport.injuries_rfd' => 'array',
            'sport.injuries_rfd.*' => 'integer|exists:injury_rfds,id|min:0',
            'sport.files_fisiotherapy' => 'array',
            'sport.files_fisiotherapy.*' => 'integer|exists:files,id|min:0',
            'sport.efforts_recovery' => 'array',
            'sport.efforts_recovery.*' => 'integer|exists:effort_recovery,id|min:0',
            'sport.nutritional_sheets' => 'array',
            'sport.nutritional_sheets.*' => 'integer|exists:nutritional_sheets,id|min:0',
            'sport.psychology_reports' => 'array',
            'sport.psychology_reports.*' => 'integer|exists:psychology_reports,id|min:0',
            // Teacher rules
            'teacher.educational_center' => 'array',
            'teacher.educational_center.*' => 'integer|exists:educational_centers,id|min:0',
            'teacher.classes' => 'array',
            'teacher.classes.*' => 'integer|exists:classes,id|min:0',
            'teacher.students' => 'array',
            'teacher.students.*' => 'integer|exists:students,id|min:0',
            'teacher.exercises' => 'array',
            'teacher.exercises.*' => 'integer|exists:exercises,id|min:0',
            'teacher.exercise_sessions' => 'array',
            'teacher.exercise_sessions.*' => 'integer|exists:exercise_sessions,id|min:0',
            'teacher.available_scenarios' => 'array',
            'teacher.available_scenarios.*' => 'integer|exists:scenarios,id|min:0',
            'teacher.tests' => 'array',
            'teacher.tests.*' => 'integer|exists:test_applications,id|min:0',
            'teacher.rubrics' => 'array',
            'teacher.rubrics.*' => 'integer|exists:rubrics,id|min:0',
            'teacher.evaluations' => 'array',
            'teacher.evaluations.*' => 'integer|exists:evaluations,id|min:0',
            'teacher.tutorships' => 'array',
            'teacher.tutorships.*' => 'integer|exists:tutorships,id|min:0',
            'teacher.grades' => 'array',
            'teacher.grades.*' => 'integer|exists:grades,id|min:0',
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
