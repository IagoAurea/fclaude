<?php

namespace Modules\Test\Entities;


use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

/**
 * @OA\Schema(
 *      title="QuestionCategory",
 *      description="QuestionCategory model",
 *      @OA\Xml( name="QuestionCategory"),
 *      @OA\Property( title="Code", property="code", description="code to identify", format="string", example="physical_abilities" ),
 *      @OA\Property( title="Question Category Code", property="question_category_code", description="Parent Category", format="string", example="physical_abilities" ),
 * )
 */
class QuestionCategory extends Model implements TranslatableContract
{
    use Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'question_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'question_category_code'
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
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'translations'
    ];

    /**
     * Returns the category object related to the  Question
     *
     * @return Array
     */
    public function child ()
    {
        return $this->HasMany(QuestionCategory::class);
    }

    /**
     * Returns the category object related to the  Question
     *
     * @return Array
     */
    public function questions()
    {
        return $this->hasMany(Question::class,'code' , 'local_key');
    }

}
