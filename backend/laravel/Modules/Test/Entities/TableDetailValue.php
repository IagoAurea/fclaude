<?php

namespace Modules\Test\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Test\Entities\TableDetail;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *      title="TableDetailValue",
 *      description="TableDetailValue model",
 *      @OA\Xml( name="TableDetailValue"),
 *      @OA\Property( title="Table Detail", property="table_detail_id", description="detail  to which it belongs", format="integer", example="1" ),
 *      @OA\Property( title="Value", property="value", description="value to detail", format="string", example="1" ),
 *      @OA\Property( title="Order", property="order", description="value position", format="string", example="1" )
 * )
 */
class TableDetailValue extends Model
{
    //use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'table_detail_values';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'table_detail_id',
        'value',
        'order'
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
     * Returns the category object related to the  Question
     * 
     * @return Array
     */
    public function table_detail () 
    {
        return $this->belongsTo(TableDetail::class);
    }

}
