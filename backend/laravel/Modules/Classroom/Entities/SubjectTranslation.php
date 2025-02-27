<?php

namespace Modules\Classroom\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      title="SubjectTranslation",
 *      description="SubjectTranslation model",
 *      @OA\Xml( name="SubjectTranslation"),
 *      @OA\Property( title="Locale", property="locale", description="translation language", format="string", example="en" ),
 *      @OA\Property( title="Phase", property="subject_id", description="entity id", format="integer", example="1" ),
 *      @OA\Property( title="Name", property="name", description="translated name", format="string", example="New subject" ) 
 * )
 */
class SubjectTranslation extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'classroom_subject_translations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
