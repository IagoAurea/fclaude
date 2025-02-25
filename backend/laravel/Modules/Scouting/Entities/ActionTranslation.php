<?php

namespace Modules\Scouting\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      title="ActionTranslation",
 *      description="ActionTranslation model",
 *      @OA\Xml( name="ActionTranslation"),
 *      @OA\Property( title="Locale", property="locale", description="translation language", format="string", example="en" ),
 *      @OA\Property( title="Plural", property="plural", description="Pluralization", format="string", example="Goals" ),
 *      @OA\Property( title="Name", property="name", description="translated name", format="string", example="Whats your name ?" )
 * )
 */
class ActionTranslation extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'action_translations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'plural'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
