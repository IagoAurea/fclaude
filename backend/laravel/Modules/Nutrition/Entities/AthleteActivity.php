<?php

namespace Modules\Nutrition\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *      title="AthleteActivity",
 *      description="AthleteActivity model",
 *      @OA\Xml( name="AthleteActivity"),
 *      @OA\Property( title="Repose", property="repose", description="number of hours at repose", format="double", example="6" ),
 *      @OA\Property( title="Very light", property="very_light", description="number of hours at", format="double", example="5" ),     
 *      @OA\Property( title="Light", property="light", description="number of hours at", format="double", example="5" ),     
 *      @OA\Property( title="Moderate", property="moderate", description="number of hours at", format="double", example="5" ),    
 *      @OA\Property( title="Intense", property="intense", description="number of hours at", format="double", example="3" ),    
 *      @OA\Property( title="Nutritional Sheet", property="nutritional_sheet_id", description="Nutritional Sheet Associate", format="integer", example="1" )    
 * * )
 */
class AthleteActivity extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'repose',
        'very_light',
        'light',
        'moderate',
        'intense',
        'nutritional_sheet_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes that should be cast to datetime types.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Returns the  nutritional sheet object related to the Athlete Activity 
     * 
     * @return Array
     */
    public function nutritionalSheet () {
        return $this->belongsTo(NutritionalSheet::class);
    }

}
