<?php

namespace Modules\Test\Entities;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Modules\Test\Entities\TestConfiguration;
use Modules\Test\Entities\TableDetail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

/**
 * @OA\Schema(
 *      title="Table",
 *      description="Table model",
 *      @OA\Xml( name="Table"),
 *      @OA\Property( title="Test Configuration", property="test_configuration_id", description="test configuration to which it belongs", format="integer", example="1" ),
 * )
 */
class Table extends Model
{
    //use SoftDeletes;
    use Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tables';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'test_configuration_id'
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
     * The attributes that are mass assignable translation.
     *
     * @var array
     */
    public $translatedAttributes = [
        'name',
        'description'
    ];

    /**
     * Returns the category object related to the  Question
     * 
     * @return Array
     */
    public function test_configuration () 
    {
        return $this->belongsTo(TestConfiguration::class);
    }

    /**
     * Returns the category object related to the  Question
     * 
     * @return Array
     */
    public function table_details () 
    {
        return $this->HasMany(TableDetail::class);
    }

}
