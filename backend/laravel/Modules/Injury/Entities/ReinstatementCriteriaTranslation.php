<?php

namespace Modules\Injury\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      title="ReinstatementCriteriaTranslation",
 *      description="ReinstatementCriteriaTranslation model",
 *      @OA\Xml( name="ReinstatementCriteriaTranslation"),
 *      @OA\Property( title="Locale", property="locale",
 *          description="translation language", format="string", example="en" ),
 *      @OA\Property( title="Reinstatement Criteria", property="reinstatement_criteria_id",
 *          description="entity id", format="integer", example="1" ),
 *      @OA\Property( title="Name", property="name",
 *          description="translated name", format="string", example="New Phase" )
 * * )
 */
class ReinstatementCriteriaTranslation extends Model
{
   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reinstatement_criteria_translations';

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
