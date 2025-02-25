<?php

namespace Modules\Test\Entities;

use Illuminate\Support\Str;
use Modules\Test\Entities\Formula;
use Modules\Test\Entities\TestType;
use Modules\Test\Entities\TestSubType;
use Modules\Test\Entities\Question;
use Illuminate\Database\Eloquent\Model;
use Modules\Test\Entities\QuestionTest;
use Astrotomic\Translatable\Translatable;
use Modules\Test\Entities\Configuration;
use Modules\Test\Entities\TestApplication;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Modules\Generality\Entities\Resource;

/**
 * @OA\Schema(
 *      title="Test",
 *      description="Test model",
 *      @OA\Xml( name="Test"),
 *      @OA\Property( title="Code", property="code", description="code to identify", format="string", example="valoration_recovery" ),
 *      @OA\Property( title="Test Type", property="test_type_id", description="Test Type ", format="integer", example="1" ),
 *      @OA\Property( title="Test Sub Type", property="test_sub_type_id", description="Test Sub Type ", format="integer", example="1" ),
 *      @OA\Property( title="Image", property="image_id", description="id of the related image", format="integer", example="34" ),
 *      @OA\Property( title="Type Valoration", property="type_valoration_code", description="Defines if the test is evaluated by points or by percentage", format="string", example="percentage" ),
 *      @OA\Property( title="Value", property="value", description="test value in percentage or points", format="double", example="100" ),
 *      @OA\Property( title="Sport", property="sport_id", description="id to sport to relate test", format="integer", example="1" )
 * )
 */
class Test extends Model
{
    use SoftDeletes;
    use Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'test_type_id',
        'inverse',
        'test_sub_type_id',
        'image_id',
        'type_valoration_code',
        'unit_group_code',
        'value',
        'sport_id'
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
        'deleted_at',
    ];

    /**
     * The attributes that are mass assignable translation.
     *
     * @var array
     */
    public $translatedAttributes = [
        'name',
        'description',
        'instruction',
        'material',
        'procedure',
        'evaluation',
        'tooltip'
    ];

    /**
     * The relationships to be inlcuded
     *
     * @var array
     */
    protected $with = [
        'image'
    ];

    /**
     * Additional fields
     * @var array
     */
    protected $appends = [
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
     * Get the team that owns the image.
     */
    public function image()
    {
        return $this->belongsTo(Resource::class);
    }

    /**
     * Returns the category object related to the  Question
     * 
     * @return Array
     */
    public function test_type()
    {
        return $this->belongsTo(TestType::class);
    }

    /**
     * Returns the category object related to the  Question
     * 
     * @return Array
     */
    public function test_sub_type()
    {
        return $this->belongsTo(TestSubType::class);
    }

    /**
     * Returns the category object related to the  Question
     * 
     * @return Array
     */
    public function test_application()
    {
        return $this->HasMany(TestApplication::class);
    }

    /**
     * Returns the category object related to the  Question
     * 
     * @return Array
     */
    public function question_test()
    {
        return $this->HasMany(QuestionTest::class);
    }

    /**
     * Returns the test object related to the  Question
     * 
     * @return Array
     */
    public function formulas()
    {
        return $this->belongsToMany(
            Formula::class,
            'test_formulas'
        )->withTimestamps();
    }

    /**
     * Returns the test object related to the  Question
     * 
     * @return Array
     */
    public function configurations()
    {
        return $this->belongsToMany(
            Configuration::class,
            'test_configurations'
        )->withTimestamps();
    }
}
