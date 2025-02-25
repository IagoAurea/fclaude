<?php

namespace Modules\AlumnControl\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\AlumnControl\Entities\DailyControlItem;

class DailyControl extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'daily_control';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'alumn_id',
        'daily_control_item_id',
        'classroom_academic_year_id',
        'academic_period_id',
        'count',
        'reset_at'
    ];

    /**
     * Register any events.
     *
     * @return void
     */
    public static function boot() {
        parent::boot();

        static::creating(function($model) {
            $model->reset_at = now();
        });
    }


    /** Relation with competition
     * @return BelongsTo
     */
    public function item()
    {
        return $this->belongsTo(DailyControlItem::class, 'daily_control_item_id');
    }
}
