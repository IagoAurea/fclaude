<?php

namespace Modules\Alumn\Entities;

use Illuminate\Database\Eloquent\Model;

class ClassroomAcademicYearAlumn extends Model
{
   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'classroom_academic_year_alumns';

    /**
     * The attributes that are hidden from querying.
     *
     * @var array
     */
    protected $hidden = [
        'pivot',
    ];

    /**
     * The relations that are included
     *
     * @var array
     */
    protected $with = [
        'alumn',
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'classroom_academic_year_id',
        'alumn_id',
    ];

    /**
     * Relation with the tutor
     *
     * @return BelongsTo
     */
    public function alumn()
    {
        return $this->belongsTo(Alumn::class);
    }


    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
