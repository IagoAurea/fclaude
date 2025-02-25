<?php

namespace Modules\Club\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\AlumnControl\Services\DailyControlService;
use Modules\Club\Database\factories\AcademicPeriodFactory;

class AcademicPeriod extends Model
{
    use HasFactory;

    /**
     * Name of the table
     *
     * @var String 
     */
    protected $table = 'academic_periods';

    /**
     * List of all fillable properties
     *
     * @var Array
     */
    protected $fillable = [
        'id',
        'academic_year_id',
        'title',
        'start_date',
        'end_date',
        'is_active'
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

     /**
     * Function boot model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if($model->is_active) {
                $model->generateDailyControlAlumns($model);
            }
        });
    }

     /**
     * Create row daily control to alumns
     *
     * @param @model
     */
    private function generateDailyControlAlumns($model)
    {
        $dailyControlService = resolve(DailyControlService::class);

        $dailyControlService->generateDailyControlAlumns($model);
    }

    /**
     * Relation with the tutor
     *
     * @return BelongsTo
     */
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return AcademicPeriodFactory::new();
    }
}
