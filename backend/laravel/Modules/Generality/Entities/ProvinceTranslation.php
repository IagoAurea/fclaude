<?php

namespace Modules\Generality\Entities;

use Illuminate\Database\Eloquent\Model;

class ProvinceTranslation extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'province_translations';

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
