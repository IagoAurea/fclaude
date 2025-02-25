<?php

namespace Modules\Test\Entities;

use Modules\Test\Entities\QuestionResponse; 
use Illuminate\Database\Eloquent\Model;
use Modules\Test\Entities\TestApplication;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *      title="TestApplicationAnswer",
 *      description="TestApplicationAnswer model",
 *      @OA\Xml( name="TestApplicationAnswer"),
 *      @OA\Property( title="Test Application", property="test_application_id", description="application to which it belongs", format="integer", example="1" ),
 *      @OA\Property( title="Question Response", property="question_responses_id", description="answer", format="integer", example="1" ),
 *      @OA\Property( title="Text Response", property="text_response", description="text response", format="string", example="My name is" ),
 * )
 */
class TestApplicationAnswer extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'test_application_answers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'test_application_id',
        'question_responses_id',
        'unit_id',
        'text_response'
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
     * The attributes that are calculated types.
     *
     * @var array
     */
    protected $appends = [
        'question',
        'question_id',
        'response',
        'value',
        'is_configuration_question',
        'color',
        'image'
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
     * Returns the category object related to the  Question
     * 
     * @return Array
     */
    public function test_application() 
    {
        return $this->belongsTo(TestApplication::class);
    }

    /**
     * Returns the category object related to the  Question
     * 
     * @return Array
     */
    public function question_responses() 
    {
        return $this->belongsTo(QuestionResponse::class);
    }

    /**
     * Get the body mass index calculated attribute
     */
    public function getQuestionAttribute()
    {
        return $this->question_responses->question_test->question->name; 
    }

     /**
     * Get the body mass index calculated attribute
     */
    public function getIsConfigurationQuestionAttribute()
    {
        return $this->question_responses->question_test->question->is_configuration_question; 
    }

     /**
     * Get the color attribute
     */
    public function getColorAttribute()
    {
        return $this->question_responses->response->color_secondary; 
    }

     /**
     * Get the image attribute
     */
    public function getImageAttribute()
    {
        return $this->question_responses->response->image; 
    }

     /**
     * Get the body mass index calculated attribute
     */
    public function getQuestionIdAttribute()
    {
        return $this->question_responses->question_test->question->id; 
    }

    /**
     * Get the body mass index calculated attribute
     */
    public function getResponseAttribute()
    {
        if ($this->text_response != "") {
            return $this->text_response; 
        }

        return $this->question_responses->response->name;
    }


    /**
     * Get the body mass index calculated attribute
     */
    public function getValueAttribute()
    {
        if ($this->text_response != "" && !is_numeric($this->text_response)) {
            return 0; 
        }

        if ($this->text_response != "" ) {
            return floatval($this->text_response); 
        }
        
        return $this->question_responses->value;
    }   
}

