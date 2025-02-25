<?php

namespace Modules\EffortRecovery\Entities;

use Illuminate\Database\Eloquent\Model;

class WellnessQuestionnaireAnswerTypeTranslation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wellness_questionnaire_answer_type_translations';

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
