<?php

namespace Modules\EffortRecovery\Entities;

use Illuminate\Database\Eloquent\Model;

// Entities
use Modules\EffortRecovery\Entities\WellnessQuestionnaireAnswerItem;

/**
 * @OA\Schema(
 *  title="WellnessQuestionnaireHistory",
 *  description="Wellness questionnaire history - Historico de questionario",
 *  @OA\Xml(name="WellnessQuestionnaireHistory"),
 *  @OA\Property(
 *      title="ID",
 *      property="id",
 *      description="History identificator - Identificador de historial",
 *      format="int64",
 *      example="1"
 *  ),
 *  @OA\Property(
 *      title="Effort Recovery ID",
 *      property="effort_recovery_id",
 *      description="Effort recovery program identificator - Identificador de programa de recuperacion del esfuerzo",
 *      format="int64",
 *      example="1"
 *  ),
 * )
 */
class WellnessQuestionnaireHistory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wellness_questionnaire_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'effort_recovery_id',
    ];

    /**
     * The attributes that must appear as hidden
     * 
     * @var array
     */
    protected $hidden = [
        'updated_at',
    ];

    /**
     * The attributes that must be auto-calculated
     * 
     * @var array
     */
    protected $appends = [
        'calculated_status'
    ];

    // ----- Calculated Fields
    /**
     * Used to calculate the total charge used though answers
     * 
     * @return string
     */
    public function getCalculatedStatusAttribute()
    {
        $total = $this->answers->sum(function($answer) {
            return $answer->charge;
        });

        $ceiled = ceil($total / 5);

        $items = [
            1 => 'very_low',
            2 => 'low',
            3 => 'normal',
            4 => 'high',
            5 => 'very_high'
        ];

        return $items[$ceiled];
    }


    // ----- Relationships

    /**
     * Returns all the answers the history lock has
     * 
     * @return array
     */
    public function answers()
    {
        return $this->belongsToMany(
            WellnessQuestionnaireAnswerItem::class, 'wellness_questionnaire_answers'
        )->with('type');
    }
}
