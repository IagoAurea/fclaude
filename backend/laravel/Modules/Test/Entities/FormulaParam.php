<?php

namespace Modules\Test\Entities;

use Modules\Test\Entities\Test;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      title="FormulaParam",
 *      description="FormulaParam model",
 *      @OA\Xml( name="FormulaParam"),
 *      @OA\Property( title="Test Formula ", property="test_formula_id", description="Test Formula associate ", format="integer", example="1" ),
 *      @OA\Property( title="Name", property="name", description="Param Name", format="string", example="param" ),
 *      @OA\Property( title="Param number", property="param", description="number to identify", format="integer", example="1" ),
 *    )
 */
class FormulaParam extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'formula_params';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'test_formula_id',
        'code',
        'param',
        'type',
        'question_responses_id'
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
        'deleted_at',
    ];


}

