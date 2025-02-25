<?php

namespace Modules\Classroom\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Classroom\Entities\Teacher;

class WorkingExperiences extends Model
{
    use SoftDeletes;

    protected $table = 'classroom_working_experiences';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'club',
        'occupation',
        'teacher_id',
        'start_date',
        'finish_date',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes that should be cast to datetime types.
     *
     * @var array
     */
    protected $dates = [
        'start_date',
        'finish_date',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes that are calculated types.
     *
     * @var array
     */
    protected $appends = [
        'time'
    ];

    /**
     * Relation with the tutor
     *
     * @return BelongsTo
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the time calculated attribute
     */
    public function getTimeAttribute()
    {
        return $this->finish_date->diffForHumans($this->start_date);
    }
}
