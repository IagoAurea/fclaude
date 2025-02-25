<?php

namespace Modules\InjuryPrevention\Entities;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

/**
 * @OA\Schema(
 *  title="InjuryPreventionProgramType",
 *  description="Injury Prevention Program Type model",
 *  @OA\Xml( name="InjuryPreventionProgramType"),
 *  @OA\Property(
 *      title="ID",
 *      property="id",
 *      description="Injury prevention identificator",
 *      format="int64",
 *      example="1"
 *  ),
 *  @OA\Property(
 *      title="Code",
 *      property="code",
 *      description="translation code",
 *      format="string",
 *      example="item_code"
 *  ),
 * )
 */
class PreventiveProgramType extends Model implements TranslatableContract
{
    use Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'preventive_program_types';

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
        'translations',
        'pivot',
        'code,'
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
