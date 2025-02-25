<?php

namespace Modules\Test\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      title="TestTranslation",
 *      description="TestTranslation model",
 *      @OA\Xml( name="TestTranslation"),
 *      @OA\Property( title="Locale", property="locale", description="translation language", format="string", example="en" ),
 *      @OA\Property( title="Description", property="description", description="Description", format="string", example="lorem" ),
 *      @OA\Property( title="Name", property="name", description="translated name", format="string", example="Test One"),
 *      @OA\Property( title="Instruction", property="instruction", description="Instruction", format="string", example="lorem" ),
 *      @OA\Property( title="Material", property="material", description="Material", format="string", example="lorem" ),
 *      @OA\Property( title="Procedure", property="procedure", description="Procedure", format="string", example="lorem" ),
 *      @OA\Property( title="Evaluation", property="evaluation", description="Evaluation", format="string", example="lorem" ),
 *      @OA\Property( title="Tooltip", property="tooltip", description="Tooltip", format="string", example="lorem" )
 * )
 */
class TestTranslation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'test_translations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'instruction',
        'material',
        'procedure',
        'evaluation',
        'tooltip'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
