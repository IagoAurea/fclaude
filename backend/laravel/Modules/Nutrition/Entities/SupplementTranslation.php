<?php

namespace Modules\Nutrition\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      title="SupplementTranslation",
 *      description="SupplementTranslation model",
 *      @OA\Xml( name="SupplementTranslation"),
 *      @OA\Property( title="Locale", property="locale", description="translation language", format="string", example="en" ),
 *      @OA\Property( title="Supplement", property="supplement_id", description="entity id", format="integer", example="1" ),
 *      @OA\Property( title="Name", property="name", description="translated name", format="string", example="iron" ) 
 * * )
 */
class SupplementTranslation extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'supplement_translations';

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
