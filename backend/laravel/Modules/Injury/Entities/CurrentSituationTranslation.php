<?php

namespace Modules\Injury\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      title="CurrentSituationTranslation",
 *      description="CurrentSituationTranslation model",
 *      @OA\Xml( name="CurrentSituationTranslation"),
 *      @OA\Property( title="Locale", property="locale", description="translation language", format="string", example="en" ),
 *      @OA\Property( title="Current Situation", property="current_situation_id", description="entity id", format="integer", example="1" ),
 *      @OA\Property( title="Name", property="name", description="translated name", format="string", example="New current situation" ) 
 * * )
 */
class CurrentSituationTranslation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'current_situation_translations';

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
