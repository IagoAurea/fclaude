<?php

namespace Modules\Fisiotherapy\Entities;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Treatment extends Model implements TranslatableContract
{
   use Translatable;

   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'treatments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code'
    ];

    /**
     * The attributes that are hidden from querying.
     *
     * @var array
     */
    protected $hidden = [
        'translations', 'pivot'
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
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
