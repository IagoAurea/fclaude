<?php

namespace Modules\EffortRecovery\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Generality\Entities\Resource;
use Astrotomic\Translatable\Translatable;
use Modules\EffortRecovery\Entities\WellnessQuestionnaireAnswerType;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

/**
 * @OA\Schema(
 *  title="WellnessQuestionnaireAnswer",
 *  description="Wellness questionnaire answer relationship entity - Entidad de relacion de respuestas de cuestionario de bienestar",
 *  @OA\Xml(name="WellnessQuestionnaireAnswer"),
 *  @OA\Property(
 *      title="Code",
 *      property="code",
 *      description="Wellness answer item translation code - Codigo de traduccion de respuesta de questionario de bienestar",
 *      format="string",
 *      example="trans_code"
 *  ),
 *  @OA\Property(
 *      title="Charge",
 *      property="charge",
 *      description="Answer item point charge - Carga de puntos de respuesta",
 *      format="int64",
 *      example="1"
 *  ),
 *  @OA\Property(
 *      title="Type ID",
 *      property="wellness_questionnaire_item_type_id",
 *      description="Identificator of the type related to the answer item - Identificador del tipo de respuesta relacionado",
 *      format="int64",
 *      example="1"
 *  ),
 * )
 */
class WellnessQuestionnaireAnswerItem extends Model implements TranslatableContract
{
    use Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wellness_questionnaire_answer_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'charge',
        'image_id',
        'wellness_questionnaire_item_type_id',
    ];
 
    /**
     * The attributes that are hidden from querying.
     *
     * @var array
     */
    protected $hidden = [
        'translations',
        'pivot',
        'code',
        'charge',
        'wellness_questionnaire_answer_type_id',
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
     * Calculated fields
     * 
     * @var array
     */
    public $appends = [
        'charge_level'
    ];

    /**
     * Allways show this relationships
     * 
     * @var array
     */
    protected $with = [
        'image'
    ];

    // ----- Calculated Fields
    /**
     * 
     */
    public function getChargeLevelAttribute()
    {
        $items = [
            1 => 'very_low',
            2 => 'low',
            3 => 'normal',
            4 => 'high',
            5 => 'very_high'
        ];

        return $items[$this->charge];
    }

    // ----- Relationships
    /**
     * Return the type of answer it is
     * 
     * @return object
     */
    public function type()
    {
        return $this->belongsTo(WellnessQuestionnaireAnswerType::class, 'wellness_questionnaire_answer_type_id');
    }

     /**
     * Returns the related image resource object
     *
     * @return Object
     */
    public function image()
    {
        return $this->belongsTo(Resource::class);
    }
}
