<?php

namespace Modules\Club\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AcademicYear extends Model
{
    use HasFactory;

    /**
     * Name of the table
     * 
     * @var String 
     */
    protected $table = 'academic_years';

    /**
     * List of all fillable properties
     * 
     * @var Array
     */
    protected $fillable = [
        'title',
        'club_id',
        'start_date',
        'end_date',
        'is_active'
    ];

    /**
     * 
     */
    protected $appends = [
        'classroom_academic_year_id',
        'active_academic_period',
    ];

    /**
     * List of hidden properties
     * 
     * @var Array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    // --------- Calculated attributes
    /**
     * Calculate the relational table id
     */
    public function getClassroomAcademicYearIdAttribute()
    {
        return $this->pivot ? $this->pivot->id : null;
    }

    /**
     * Retrieves an academic period item if current date is between date range
     * 
     * @return AcademicPeriod|null
     */
    public function getActiveAcademicPeriodAttribute()
    {
        if (!$this->academicPeriods) { return null; }

        foreach ($this->academicPeriods as $academicPeriod) {
            $startDate = Carbon::createFromFormat('Y-m-d', $academicPeriod->start_date);
            $endDate = Carbon::createFromFormat('Y-m-d', $academicPeriod->end_date);

            $isBetweenDates = Carbon::now()->between(
                $startDate->startOfDay(),
                $endDate->endOfDay()
            );

            if ($isBetweenDates) {
                return $academicPeriod;
            }
        }

        return null;
    }

    // --------- Relationships
    /**
     * Relation with the academic periods
     * 
     * @return hasMany
     */
    public function academicPeriods()
    {
        return $this->hasMany(AcademicPeriod::class);
    }

    /**
     * Factory
     */
    protected static function newFactory()
    {
        return \Modules\Club\Database\factories\AcademicYearFactory::new();
    }
}
