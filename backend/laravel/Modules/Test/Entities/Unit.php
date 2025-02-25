<?php

namespace Modules\Test\Entities;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

/**
 * @OA\Schema(
 *      title="Unit",
 *      description="Unit model",
 *      @OA\Xml( name="Unit"),
 *      @OA\Property( title="Code", property="code", description="code to identify", format="string", example="kg" ),
 *      @OA\Property( title="Abbreviation", property="abbreviation", description="translated abbreviation", format="string", example="kg" )
 * )
 */
class Unit extends Model
{
    use Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'units';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'abbreviation'
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
     * List of hidden properties of the model
     * 
     * @var Array
     */
    protected $hidden = [
        'translations'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
