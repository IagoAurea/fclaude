<?php

namespace Modules\InjuryPrevention\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *  title="InjuryPreventionEvaluationQuestionTranslation",
 *  description="Injury Prevention Program Type model",
 *  @OA\Xml( name="InjuryPreventionEvaluationQuestionTranslation"),
 *  @OA\Property(
 *      title="ID",
 *      property="id",
 *      description="Injury prevention evaluation question identificator",
 *      format="int64",
 *      example="1"
 *  ),
 *  @OA\Property(
 *      title="Locale",
 *      property="locale",
 *      description="Language translation locale code",
 *      format="string",
 *      example="en"
 *  ),
 *  @OA\Property(
 *      title="Name",
 *      property="name",
 *      description="Name of the translated item",
 *      format="string",
 *      example="English item"
 *  ),
 *  @OA\Property(
 *      title="Evluation question Program Type ID",
 *      property="evaluation_question_id",
 *      description="Identificator of the program evlauation question",
 *      format="int64",
 *      example="1"
 *  ),
 * )
 */
class EvaluationQuestionTranslation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'evaluation_question_translations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
