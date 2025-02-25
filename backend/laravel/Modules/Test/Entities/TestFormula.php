<?php

namespace Modules\Test\Entities;

use Modules\Test\Entities\Formula;
use Illuminate\Database\Eloquent\Model;
use Modules\Test\Entities\FormulaParam;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *      title="TestFormula",
 *      description="TestFormula model",
 *      @OA\Xml( name="TestFormula"),
 *      @OA\Property( title="Test ", property="test_id", description="Test associate ", format="integer", example="1" ),
 *      @OA\Property( title="Formula", property="formula_id",
 *      description="id of the related formula", format="integer", example="2" ),
 *    )
 */
class TestFormula extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'test_formulas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'formula_id',
        'test_id'
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

    /**
     * Returns the category object related to the  Question
     * 
     * @return Array
     */
    public function formula_params ()
    {
        return $this->HasMany(FormulaParam::class);
    }

    /**
     * Returns the category object related to the  Question
     * 
     * @return Array
     */
    public function formula ()
    {
        return $this->belongsTo(Formula::class);
    }

}

