<?php

namespace Modules\Nutrition\Entities;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

/**
 * @OA\Schema(
 *      title="Supplement",
 *      description="Supplement model",
 *      @OA\Xml( name="Supplement"),
 *      @OA\Property( title="Code", property="code", description="code to identify", format="string", example="new" ),
 * * )
 */
class Supplement extends Model implements TranslatableContract
{
    use Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'supplements';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code'
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

    /**
     * Returns a list of nutritional sheets objects related to the supplement
     * 
     * @return Array
     */
    public function nutritionalSheets () {
        return $this->belongsToMany(
            NutritionalSheet::class, 'nutritional_sheet_supplement'
        )->withTimestamps();
    }

}
