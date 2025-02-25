<?php

namespace Modules\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Indicator extends Model
{
    use HasFactory;

    protected $table = 'evaluation_indicators';
    protected $fillable = [
        'name',
        'percentage',
        'evaluation_criteria',
        'insufficient_caption',
        'sufficient_caption',
        'remarkable_caption',
        'outstanding_caption',
        'created_at',
        'updated_at'
    ];

    protected $with = ['competences'];

    /**
     * The competences that belong to the indicator.
     * 
     * @return BelongsToMany
     */
    public function competences()
    {
        return $this->belongsToMany(Competence::class, 'competence_indicator');
    }

    /**
     * The rubrics that belong to the indicator.
     * 
     * @return BelongsToMany
     */
    public function rubrics()
    {
        return $this->belongsToMany(Rubric::class, 'indicator_rubric');
    }


    protected static function newFactory()
    {
        return \Modules\Evaluation\Database\factories\IndicatorFactory::new();
    }
}
