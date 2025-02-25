<?php

namespace Modules\Injury\Entities;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;


/**
 * @OA\Schema(
 *      title="CurrentSituation",
 *      description="CurrentSituation model",
 *      @OA\Xml( name="CurrentSituation"),
 *      @OA\Property( title="Code", property="code", description="code to identify", format="string", example="physical_abilities" ),
 *      @OA\Property( title="Color", property="color", description="color to status", format="string", example="#fffff" ),     
 *      @OA\Property( title="Min Percentage", property="min_percentage", description="lower limit for status", format="double", example="84,99" ),     
 *      @OA\Property( title="Max Percentage", property="max_percentage", description="upper limit for state", format="double", example="100" ),    
 *      @OA\Property( title="Type", property="type", description="indicates if it is for the rfd test or the psychological", format="integer", example="1" )    
 * * )
 */
class CurrentSituation extends Model
{
    use Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'current_situations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'color',
        'min_percentage',
        'max_percentage',
        'type'
    ];

     /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'translations'
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
