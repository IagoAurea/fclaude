<?php

namespace Modules\Training\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *      title="TargetSessionTranslation",
 *      description="TargetSessionTranslation model",
 *      @OA\Xml( name="TargetSessionTranslation"),
 *      @OA\Property( title="Locale", property="locale", description="translation language", format="string", example="en" ),
 *      @OA\Property( title="Target", property="target_session_id", description="entity id", format="integer", example="1" ),
 *      @OA\Property( title="Name", property="name", description="translated name", format="string", example="Target" ) 
 * * )
 */
class TargetSessionTranslation extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'target_session_translations';

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
