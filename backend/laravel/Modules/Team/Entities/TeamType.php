<?php

namespace Modules\Team\Entities;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class TeamType extends Model implements TranslatableContract
{
    use Translatable;

   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'team_type';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code'
    ];

    /**
     * The attributes that are mass assignable translation.
     *
     * @var array
     */
    public $translatedAttributes = [
        'name'
    ];

    /**
     * The attributes that must not be retrieved when querying
     * 
     * @var array
     */
    public $hidden = [
        'translations'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
