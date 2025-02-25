<?php

namespace Modules\Generality\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Season extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'seasons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start',
        'end',
        'active',
    ];

     /**
     * The attributes that are mass appends.
     *
     * @var array
     */
    protected $appends = [
        'name'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Return field start and end season
     */

    public function getNameAttribute()
    {
        return $this->start . '/' . $this->end;
    }
}
