<?php

namespace Modules\Test\Entities;


use Illuminate\Support\Str;
use Modules\Test\Entities\Response;
use Modules\Test\Entities\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *      title="QuestionTest",
 *      description="QuestionTest model",
 *      @OA\Xml( name="QuestionTest"),
 *      @OA\Property( title="Question", property="question_id", description="question id", format="integer", example="27" ),
 *      @OA\Property( title="Test", property="test_id", description="test id", format="integer", example="1" ),
 *      @OA\Property( title="Value", property="value", description="response value", format="string", example="5" ),
 *      @OA\Property( title="Code", property="code", description="code to indentify", format="string", example="code" )
 * )
 */
class QuestionTest extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'question_tests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id',
        'test_id',
        'value',
        'code'
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
     * Register any events.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->code = Str::uuid()->toString();
        });
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
        )->withPivot('value')->orderBy('value');
    }

    /**
     * Returns the category object related to the  Question
     * 
     * @return Array
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Returns the category object related to the  Question
     * 
     * @return Array
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
