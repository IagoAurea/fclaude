<?php

namespace Modules\Club\Entities;

use Illuminate\Database\Eloquent\Model;

class SchoolCenterTypeTranslation extends Model
{
   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'school_center_type_translations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
