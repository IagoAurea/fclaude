<?php

namespace Modules\Test\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      title="QuestionTranslation",
 *      description="QuestionTranslation model",
 *      @OA\Xml( name="QuestionTranslation"),
 *      @OA\Property( title="Locale", property="locale", description="translation language", format="string", example="en" ),
 *      @OA\Property( title="Question", property="question_id", description="entity id", format="integer", example="1" ),
 *      @OA\Property( title="Name", property="name", description="translated name", format="string", example="Whats your name ?" )
 * )
 */
class QuestionTranslation extends Model
{
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'question_translations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'tooltip'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

}
