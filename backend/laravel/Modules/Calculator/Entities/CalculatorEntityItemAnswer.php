<?php

namespace Modules\Calculator\Entities;

use Illuminate\Database\Eloquent\Model;

// Entities
use Modules\Calculator\Entities\CalculatorEntityItemPointValue;

/**
 * @OA\Schema(
 *      title="CalculatorEntityItemAnswer",
 *      description="Calculator Entity Item Answer Model",
 *      @OA\Xml( name="CalculatorEntityItemAnswer"),
 *      @OA\Property(
 *          title="Calculator Entity Answer Historial Record",
 *          property="calculator_entity_answer_historical_record_id",
 *          description="References the historical record related to the calculation done",
 *          format="int64",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="Calculator Entity Item Point Value ID",
 *          property="calculator_entity_item_point_value_id",
 *          description="Identificator of the point value item related to the answer",
 *          format="int64",
 *          example="1"
 *      )
 * )
 */
class CalculatorEntityItemAnswer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'calculator_entity_item_answers';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'calculator_entity_answer_historical_record_id',
        'calculator_entity_item_point_value_id'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    // ---- Relationships

    /**
     * Retrieves the specific point value item
     * 
     * @return array
     */
    public function calculatorEntityItemPointValue()
    {
        return $this->belongsTo(CalculatorEntityItemPointValue::class)->select(
            'id', 'title'
        );
    }
}
