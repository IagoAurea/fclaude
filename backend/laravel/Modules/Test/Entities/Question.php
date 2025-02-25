<?php

namespace Modules\Test\Entities;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Test\Entities\QuestionCategory;
use Modules\Test\Entities\Test;
use Modules\Test\Entities\Unit;
use Modules\Test\Entities\Response;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

/**
 * @OA\Schema(
 *      title="Question",
 *      description="Question model",
 *      @OA\Xml( name="Question"),
 *      @OA\Property( title="Code", property="code", description="code to identify", format="string", example="physical_abilities" ),
 *      @OA\Property( title="Question Category Code", property="question_category_code", description="Parent Category", format="string", example="physical_abilities" ),
 * )
 */
class Question extends Model implements TranslatableContract
{
    use SoftDeletes;
    use Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'questions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_category_code',
        'field_type',
        'required',
        'unit_id',
        'is_configuration_question',
        'configuration_question_index'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'pivot',
        'translations'
    ];

    /**
     * The attributes that should be cast to datetime types.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes that are mass assignable translation.
     *
     * @var array
     */
    public $translatedAttributes = [
        'name',
        'tooltip'
    ];

    /**
     * Register any events.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($model->code == "") {
                $model->code = Str::uuid()->toString();
            }
        });
    }

    /**
     * Returns the category object related to the Question
     * 
     * @return Array
     */
    public function question_category()
    {
        return $this->belongsTo(QuestionCategory::class, 'question_category_code', 'code');
    }

    /**
     * Returns the unity object related to the Question
     * 
     * @return Array
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Returns the test object related to the  Question
     * 
     * @return Array
     */
    public function tests()
    {
        return $this->belongsToMany(
            Test::class,
            'question_tests'
        )->withTimestamps()->withPivot('id');
    }

    /**
     * Returns the test object related to the  Question
     * 
     * @return Array
     */
    public function responses()
    {
        return $this->belongsToMany(
            Response::class,
            'question_responses'
        )->withTimestamps();
    }
}
