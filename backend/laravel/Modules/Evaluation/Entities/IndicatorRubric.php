<?php

namespace Modules\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

class IndicatorRubric extends Model
{
    protected $table = 'indicator_rubric';
    protected $with = ['indicator'];

    /**
     * The indicators that belong to the rubric.
     * 
     * @return BelongsToMany
     */
    public function indicator()
    {
        return $this->belongsTo(Indicator::class);
    }
}
