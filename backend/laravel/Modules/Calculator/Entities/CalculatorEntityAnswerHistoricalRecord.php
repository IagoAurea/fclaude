<?php

namespace Modules\Calculator\Entities;

use Illuminate\Database\Eloquent\Model;

// Entities
use Modules\Calculator\Entities\CalculatorEntityItemAnswer;

/**
 * @OA\Schema(
 *      title="CalculatorEntityAnswerHistoricalRecord",
 *      description="Calculator Entity Answer Historical Record Model",
 *      @OA\Xml( name="CalculatorEntityAnswerHistoricalRecord"),
 *      @OA\Property(
 *          title="Entity Type",
 *          property="entity_type",
 *          description="References the entity class name",
 *          format="string",
 *          example="Modules\Injury\Entities\InjuryPevention"
 *      ),
 *      @OA\Property(
 *          title="Entity ID",
 *          property="entity_id",
 *          description="Identificator of entity",
 *          format="int64",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="Total Points",
 *          property="total_points",
 *          description="Total points resuting from calculation operation",
 *          format="int64",
 *          example="10"
 *      )
 * )
 */
class CalculatorEntityAnswerHistoricalRecord extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'calculator_entity_answer_historical_records';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entity_type',
        'entity_id',
        'total_points',
    ];

    /**
     * The attributes that must not be shown by querying.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at',
        'entity_type',
    ];

    // ---- Relationships
    /**
     * Get all of the models that own activities.
     * 
     * @return array
     */
    public function entity () {
        return $this->morphTo();
    }

    /**
     * Get all of the history record related answers
     * 
     * @return array
     */
    public function calculatorEntityItemAnswers()
    {
        return $this->hasMany(CalculatorEntityItemAnswer::class);
    }
    
    /**
     * 
     */
    public function calculationEntityItemPointValues()
    {
        return $this->belongsToMany(CalculatorEntityItemPointValue::class, 'calculator_entity_item_answers');
    }
}
