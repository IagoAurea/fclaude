<?php

namespace Modules\Evaluation\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Alumn\Entities\Alumn;

class EvaluationResult extends Model
{
    use HasFactory;

    const STATUS_NOT_EVALUATED = 'not_evaluated';
    const STATUS_EVALUATED = 'evaluated';

    /**
     * Name of the table
     * 
     * @var String 
     */
    protected $table = 'rubric_evaluation_results';

    /**
     * List of relationships to be included on queries
     * 
     * @var Array
     */
    protected $with = [
        'rubric',
        'alumn'
    ];

    /**
     * List of all fillable properties
     * 
     * @var Array
     */
    protected $fillable = [
        'alumn_id',
        'classroom_academic_year_id',
        'evaluation_rubric_id',
        'user_id',
        'status',
        'evaluation_grade',
        'qualification_grade',
    ];

    /**
     * Relation with the rubric
     * 
     * @return BelongsTo
     */
    public function rubric()
    {
        return $this->belongsTo(Rubric::class, 'evaluation_rubric_id');
    }

    /**
     * Relation with the rubric
     * 
     * @return BelongsTo
     */
    public function alumn()
    {
        return $this->belongsTo(Alumn::class, 'alumn_id');
    }

    /**
     * Factory
     */
    protected static function newFactory()
    {
        return \Modules\Evaluation\Database\factories\EvaluationResultFactory::new();
    }
}
