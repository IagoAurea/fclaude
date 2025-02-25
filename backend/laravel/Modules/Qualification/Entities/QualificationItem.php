<?php

namespace Modules\Qualification\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Evaluation\Entities\Rubric;

class QualificationItem extends Model
{
    use HasFactory;

    /**
     * Name of the table
     *
     * @var String
     */
    protected $table = 'classroom_academic_year_rubric_qualifications';

    /**
     * List of relationships to be included on queries
     *
     * @var Array
     */
    protected $with = [
        'rubric'
    ];

    /**
     * List of all fillable properties
     *
     * @var Array
     */
    protected $fillable = [
        'qualification_id',
        'rubric_id',
        'percentage',
        'status'
    ];

    /**
     * The indicators that belong to the rubric.
     *
     * @return BelongsTo
     */
    public function qualification()
    {
        return $this->belongsTo(Qualification::class);
    }

    /**
     * The classroom rubric.
     *
     * @return BelongsTo
     */
    public function rubric()
    {
        return $this->belongsTo(Rubric::class);
    }

}
