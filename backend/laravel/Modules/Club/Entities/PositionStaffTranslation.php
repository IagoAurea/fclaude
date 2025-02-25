<?php

namespace Modules\Club\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      title="PositionStaffTranslation",
 *      description="PositionStaffTranslation model",
 *      @OA\Xml( name="PositionStaffTranslation"),
 *      @OA\Property( title="Locale", property="locale", description="translation language", format="string", example="en" ),
 *      @OA\Property( title="Position Staff", property="position_staff_id", description="entity id", format="integer", example="1" ),
 *      @OA\Property( title="Name", property="name", description="translated name", format="string", example="Position" ) 
 * * )
 */
class PositionStaffTranslation extends Model
{
   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'position_staff_translations';

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
