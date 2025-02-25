<?php

namespace Modules\Generality\Entities;

use Illuminate\Database\Eloquent\Model;

class SplashTranslation extends Model
{
   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'splash_translations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'text_url'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
