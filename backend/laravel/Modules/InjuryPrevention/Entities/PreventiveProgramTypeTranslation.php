<?php

namespace Modules\InjuryPrevention\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *  title="InjuryPreventionProgramTypeTranslation",
 *  description="Injury Prevention Program Type model",
 *  @OA\Xml( name="InjuryPreventionProgramTypeTranslation"),
 *  @OA\Property(
 *      title="ID",
 *      property="id",
 *      description="Injury prevention identificator",
 *      format="int64",
 *      example="1"
 *  ),
 *  @OA\Property(
 *      title="Locale",
 *      property="locale",
 *      description="Language translation locale code",
 *      format="string",
 *      example="en"
 *  ),
 *  @OA\Property(
 *      title="Name",
 *      property="name",
 *      description="Name of the translated item",
 *      format="string",
 *      example="English item"
 *  ),
 *  @OA\Property(
 *      title="Preventive Program Type ID",
 *      property="preventive_program_type_id",
 *      description="Identificator of the preventive program type",
 *      format="int64",
 *      example="1"
 *  ),
 * )
 */
class PreventiveProgramTypeTranslation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'preventive_program_type_translations';

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
