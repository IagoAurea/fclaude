<?php

namespace Modules\Calculator\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      title="CalculatorEntityItemPointValue",
 *      description="Calculator Entity Item Point Value",
 *      @OA\Xml( name="CalculatorEntityItemPointValue"),
 *      @OA\Property(
 *          title="Logical Condition",
 *          property="condition",
 *          description="References a dinamicaly logical condition in order to be evaluated inside point sum from calculation",
 *          format="int64",
 *          example="$var > 20 && $var < 30"
 *      ),
 *      @OA\Property(
 *          title="Title",
 *          property="title",
 *          description="Title of the answer item",
 *          format="int64",
 *          example="What is the color?"
 *      ),
 *      @OA\Property(
 *          title="Points",
 *          property="points",
 *          description="Points that the answer will accumulate",
 *          format="int64",
 *          example="5"
 *      ),
 *      @OA\Property(
 *          title="Calculator Item ID",
 *          property="calculator_item_id",
 *          description="Identificator of the related calculator item",
 *          format="int64",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="Calculator Item Type ID",
 *          property="calculator_item_type_id",
 *          description="Identificator of the related calculator item type",
 *          format="int64",
 *          example="1"
 *      )
 * )
 */
class CalculatorEntityItemPointValue extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'calculator_entity_item_point_values';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'condition',
        'title',
        'points',
        'calculator_item_id',
        'calculator_item_type_id',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
