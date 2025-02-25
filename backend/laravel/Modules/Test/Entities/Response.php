<?php

namespace Modules\Test\Entities;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Modules\Test\Entities\QuestionResponse;
use Modules\Test\Entities\TypeValoration;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Modules\Generality\Entities\Resource;

/**
 * @OA\Schema(
 *      title="Response",
 *      description="Response model",
 *      @OA\Xml( name="Response"),
 *      @OA\Property( title="Code", property="code", description="code to identify", format="string", example="code_to_response" ),
 *      @OA\Property( title="Color", property="color", description="color", format="string", example="#fffff" ),
 *      @OA\Property( title="Color Secondary", property="color_secondary", description="color secondary", format="string", example="#fffff" ),
 * )
 */
class Response extends Model
{
    use SoftDeletes;
    use Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'responses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'color',
        'color_secondary',
        'image_id',
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
        'translations',
        'pivot'
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
     * Returns the test object related to the  Question
     * 
     * @return Array
     */
    public function questions()
    {
        return $this->belongsToMany(
            QuestionResponse::class,
            'question_responses'
        )->withTimestamps();
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
