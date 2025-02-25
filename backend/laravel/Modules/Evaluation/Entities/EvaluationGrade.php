<?php

namespace Modules\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EvaluationGrade extends Model
{
    use SoftDeletes;

    /**
     * Name of the table
     * 
     * @var String 
     */
    protected $table = 'rubric_evaluation_grades';

    /**
     * List of relationships to be included on queries
     * 
     * @var Array
     */
    protected $with = 'indicatorRubric';

    /**
     * List of all fillable properties
     * 
     * @var Array
     */
    protected $fillable = [
        'alumn_id',
        'classroom_academic_year_id',
        'indicator_rubric_id',
        'grade',
    ];

    /**
     * The indicators that belong to the rubric.
     * 
     * @return BelongsToMany
     */
    public function indicatorRubric()
    {
        return $this->belongsTo(IndicatorRubric::class);
    }
}
