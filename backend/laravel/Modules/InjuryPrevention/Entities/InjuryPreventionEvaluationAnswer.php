<?php

namespace Modules\InjuryPrevention\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *  title="InjuryPreventionEvaluationAnswer",
 *  description="Injury Prevention Program Type model",
 *  @OA\Xml( name="InjuryPreventionEvaluationAnswer"),
 *  @OA\Property(
 *      title="Evaluation question id",
 *      property="evaluation_question_id",
 *      description="Identificator of injury program evaluation question",
 *      format="int64",
 *      example="1"
 *  ),
 *  @OA\Property(
 *      title="Injury prevention id",
 *      property="injury_prevention_id",
 *      description="Identificator of injury prevention program",
 *      format="int64",
 *      example="1"
 *  ),
 *  @OA\Property(
 *      title="Name",
 *      property="name",
 *      description="Name of the translated item",
 *      format="string",
 *      example="English item"
 *  ),
 *  @OA\Property(
 *      title="Evaluation question answer value",
 *      property="value",
 *      description="Is the point value that the response has according to the evaluation",
 *      format="int64",
 *      example="1"
 *  ),
 * )
 */
class InjuryPreventionEvaluationAnswer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'injury_prevention_evaluation_answers';
    
    /**
     * Table primary key name type.
     * 
     * @var int
     */
    protected $primaryKey = null;

    /**
     * Table incrementing id behavior.
     * 
     * @var boolean
     */
    public $incrementing = false;

    /**
     * Disabled timestamps for not inserting data
     * 
     * @var boolean
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'evaluation_question_id',
        'injury_prevention_id',
        'value',
    ];
}
