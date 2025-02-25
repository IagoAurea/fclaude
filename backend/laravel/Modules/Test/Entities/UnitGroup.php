<?php

namespace Modules\Test\Entities;

use Illuminate\Database\Eloquent\Model;

class UnitGroup extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'unit_groups';

    /**
     * The fields to be fillable
     *
     * @var string
     */
    protected $fillable = [
        'code',
        'unit_id'
    ];

    /**
     * Get the team that owns the image.
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
