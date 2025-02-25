<?php

namespace Modules\Test\Entities;

use Modules\Test\Entities\Unit;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      title="Formula",
 *      description="Formula model",
 *      @OA\Xml( name="Formula"),
 *      @OA\Property( title="Code", property="code", description="formula code", format="string", example="calculate " ),
 *      @OA\Property( title="Name", property="name", description="formula name", format="string", example="calculate " ),
 *      @OA\Property( title="Description", property="description", description="Descrition", format="string", example="calculate" ),
 *      @OA\Property( title="Formula", property="formula", description="formula execute", format="string", example="$1 + $2 / $3" ),
 * )
 */
class Formula extends Model
{
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'formulas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'description',
        'formula'
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
     * Allways show this relationships
     * 
     * @var array
     */
    protected $with = [
        'unit'
    ];

    /**
     * Returns the unity object related to the Formula
     * 
     * @return Array
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}

    

