<?php

namespace Modules\Test\Entities;

use Illuminate\Support\Str;
use Modules\Test\Entities\Unit;
use Modules\Test\Entities\Response;
use Illuminate\Database\Eloquent\Model;
use Modules\Test\Entities\QuestionTest;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @OA\Schema(
 *      title="QuestionResponse",
 *      description="QuestionResponse model",
 *      @OA\Xml( name="QuestionResponse"),
 *      @OA\Property( title="Question Test", property="question_test_id", description="test question that answers", format="integer", example="27" ),
 *      @OA\Property( title="Response", property="response_id", description="id answers", format="integer", example="1" ),
 *      @OA\Property( title="Value", property="value", description="response value", format="string", example="5" ),
 *      @OA\Property( title="Code", property="code", description="code to indentify", format="string", example="principal_code" )
 * )
 */
class QuestionResponse extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'question_responses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_test_id',
        'response_id',
        'value',
        'cal_value',
        'is_index',
        'laterality',
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
        'deleted_at'
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
    public static function boot() {
        parent::boot();

        static::creating(function($model) {
                $model->code = Str::uuid()->toString();
        });
    }

    /**
     * Returns the question test object related to the Question Response
     * 
     * @return Array
     */
    public function question_test () 
    {
        return $this->belongsTo(QuestionTest::class);
    }

    /**
     * Returns the Unit object related to the Question Response
     * 
     * @return Array
     */
    public function unit () 
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Returns the response object related to the  Question Response
     * 
     * @return Array
     */
    public function response () 
    {
        return $this->belongsTo(Response::class);
    }

}
