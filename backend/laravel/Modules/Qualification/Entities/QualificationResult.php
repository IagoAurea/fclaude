<?php

namespace Modules\Qualification\Entities;

use Modules\Qualification\Entities\QualificationItem;
use Illuminate\Database\Eloquent\Model;
use Modules\Alumn\Entities\Alumn;

class QualificationResult extends Model
{
    /**
     * Name of the table
     *
     * @var String
     */
    protected $table = 'qualification_results';

    /**
     * List of all fillable properties
     *
     * @var Array
     */
    protected $fillable = [
        'qualification_id',
        'qualification_item_id',
        'alumn_id',
        'result',
        'competence_score'
    ];

    protected $casts = [
        'competence_score' => 'array',
    ];

    /**
     * The qualification.
     *
     * @return BelongsToMany
     */
    public function qualificationItem()
    {
        return $this->belongsTo(QualificationItem::class);
    }

    /**
     * The qualification.
     *
     * @return BelongsToMany
     */
    public function alumn()
    {
        return $this->belongsTo(Alumn::class);
    }
}
