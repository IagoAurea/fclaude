<?php

namespace Modules\Test\Entities;

use Modules\Test\Entities\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *      title="TestConfiguration",
 *      description="TestConfiguration model",
 *      @OA\Xml( name="TestConfiguration"),
 *      @OA\Property( title="Test", property="test_id", description="test associate", format="integer", example="1 " ),
 *      @OA\Property( title="Configuration", property="configuration_id", description="Configuration associate", format="integer", example="1" ),
 * )
 */
class TestConfiguration extends Model
{
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'test_configurations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'test_id',
        'configuration_id'
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
     * Returns the category object related to the  Question
     * 
     * @return Array
     */
    public function table () 
    {
        return $this->HasOne(Table::class);
    }

}

    

