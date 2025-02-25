<?php

namespace Modules\Calculator\Entities;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

// Entitites
use Modules\Calculator\Entities\CalculatorEntityItemPointValue;

/**
 * @OA\Schema(
 *      title="CalculatorItem",
 *      description="Calculator Item",
 *      @OA\Xml( name="CalculatorItem"),
 *      @OA\Property(
 *          title="Code",
 *          property="code",
 *          description="String code for item translation",
 *          format="int64",
 *          example="calculation_item"
 *      ),
 *      @OA\Property(
 *          title="Is Fillable",
 *          property="is_fillable",
 *          description="Checks if the answer should come as a text input or no",
 *          format="boolean",
 *          example="false"
 *      ),
 *      @OA\Property(
 *          title="Calculation Var",
 *          property="calculation_var",
 *          description="Code-string representing the variable that should be used for calculation",
 *          format="string",
 *          example="$var"
 *      ),
 *      @OA\Property(
 *          title="Percentage",
 *          property="percentage",
 *          description="Is the percentage of the points that should be used for evaluation",
 *          format="decimal",
 *          example="0.8"
 *      ),
 *      @OA\Property(
 *          title="Entity Class",
 *          property="entity_class",
 *          description="Is the class that has calculation items related",
 *          format="string",
 *          example="injury_prevention"
 *      )
 * )
 */
class CalculatorItem extends Model implements TranslatableContract
{
    use Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'calculator_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'is_fillable',
        'entity_class',
        'calculation_var',
        'percentage',
    ];
 
    /**
     * The attributes that are hidden from querying.
     *
     * @var array
     */
    protected $hidden = [
        'translations',
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

    // -- Relationships
    
    /**
     * Retrieves all the value points related to the item
     * 
     * @return array
     */
    public function calculatorEntityItemPointValues()
    {
        return $this->hasMany(CalculatorEntityItemPointValue::class);
    }
}
