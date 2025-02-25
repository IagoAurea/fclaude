<?php

namespace Modules\Injury\Entities;

use Modules\Test\Entities\Test;
use Modules\Injury\Entities\PhaseDetail;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

/**
 * @OA\Schema(
 *      title="Phase",
 *      description="Phase model",
 *      @OA\Xml( name="Phase"),
 *      @OA\Property( title="Code", property="code",
 *          description="code to identify", format="string", example="new" ),
 *      @OA\Property( title="Test code", property="test_code",
 *          description="test code identify", format="string", example="retraining" ),
 *      @OA\Property( title="Percentage Value", property="percentage_value",
 *          description="phase value", format="double", example="84.99" ),
 *      @OA\Property( title="Min Percentage Passed", property="min_percentage_pass",
 *          description="phase value", format="double", example="84.99" )
 * * )
 */
class Phase extends Model implements TranslatableContract
{
    use Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'phases';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'test_code',
        'percentage_value',
        'min_percentage_pass',
        'code'
    ];


    /**
     * The attributes that are mass assignable translation.
     *
     * @var array
     */
    public $translatedAttributes = [
        'name'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'translations'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Returns the test objects related to the  phase
     * 
     * @return Array
     */
    public function test()
    {
        return $this->belongTo(Test::class);
    }

    /**
     * Returns the phase details objects related to the phase
     * 
     * @return Array
     */
    public function phase_details()
    {
        return $this->HasMany(PhaseDetail::class);
    }
}
