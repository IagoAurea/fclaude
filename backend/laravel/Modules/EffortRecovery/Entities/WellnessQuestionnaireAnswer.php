<?php

namespace Modules\EffortRecovery\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *  title="WellnessQuestionnaireAnswer",
 *  description="Wellness questionnaire answer relationship entity - Entidad de relacion de respuestas de cuestionario de bienestar",
 *  @OA\Xml(name="WellnessQuestionnaireAnswer"),
 *  @OA\Property(
 *      title="History ID",
 *      property="wellness_questionnaire_history_id",
 *      description="Wellness questionnaire history identificator - Identificador de historico de questionario de bienestar",
 *      format="int64",
 *      example="1"
 *  ),
 *  @OA\Property(
 *      title="Answer Item ID",
 *      property="wellness_questionnaire_answer_item_id",
 *      description="Answer item identificator - Identificador de respuesta de questionario",
 *      format="int64",
 *      example="1"
 *  ),
 * )
 */
class WellnessQuestionnaireAnswer extends Model
{   
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wellness_questionnaire_answers';

    /**
     * Table primary key name type.
     * 
     * @var int
     */
    protected $primaryKey = null;

    /**
     * Disables the incrementing feature from table
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'wellness_questionnaire_history_id',
        'wellness_questionnaire_answer_item_id',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
