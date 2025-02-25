<?php

namespace Modules\Player\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      title="SkillsTranslation",
 *      description="SkillsTranslation model",
 *      @OA\Xml( name="SkillsTranslation"),
 *      @OA\Property( title="Locale", property="locale", description="translation language", format="string", example="en" ),
 *      @OA\Property( title="Skill", property="skills_id", description="entity id", format="integer", example="1" ),
 *      @OA\Property( title="Name", property="name", description="translated name", format="string", example="Skill Special" )
 * )
 */
class SkillsTranslation extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'skills_translations';

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
