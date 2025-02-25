<?php

namespace Modules\EffortRecovery\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Generality\Entities\Resource;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

/**
 * @OA\Schema(
 *  title="WellnessQuestionnaireAnswerType",
 *  description="Wellness questionnaire answer item type - Tipo de respuesta de quesionario",
 *  @OA\Xml(name="WellnessQuestionnaireAnswerType"),
 *  @OA\Property(
 *      title="ID",
 *      property="id",
 *      description="Answer type identificator - Identificador de tipo de respuesta",
 *      format="int64",
 *      example="1"
 *  ),
 *  @OA\Property(
 *      title="Code",
 *      property="code",
 *      description="Translation code - Codigo de traduccion",
 *      format="string",
 *      example="trans_code"
 *  ),
 * )
 */
class WellnessQuestionnaireAnswerType extends Model implements TranslatableContract
{
    use Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wellness_questionnaire_answer_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'image_id'
    ];
 
    /**
     * The attributes that are hidden from querying.
     *
     * @var array
     */
    protected $hidden = [
        'translations',
        'code',
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
     * Allways show this relationships
     * 
     * @var array
     */
    protected $with = [
        'image'
    ];

    // ------ Relationships
    /**
     * Retrieves all related items to the type
     * 
     * @return Array
     */
    public function items()
    {
        return $this->hasMany(WellnessQuestionnaireAnswerItem::class);
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
