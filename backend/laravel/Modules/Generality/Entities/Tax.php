<?php

namespace Modules\Generality\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      title="Tax",
 *      description="Tax model",
 *      @OA\Xml( name="Tax"),
 *      @OA\Property(
 *          title="Name",
 *          property="name",
 *          description="Tax name",
 *          format="string",
 *          example="Taxname123"
 *      ),
 *      @OA\Property(
 *          title="Value",
 *          property="value",
 *          description="It's the numeric value of the tax",
 *          format="decimal",
 *          example="1.52"
 *      ),
 *      @OA\Property(
 *          title="Type",
 *          property="type",
 *          description="Tax type",
 *          format="int64",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="User Type",
 *          property="type_user",
 *          description="User type of tax",
 *          format="boolean",
 *          example="false"
 *      ),
 *      @OA\Property(
 *          title="Taxable Identificator",
 *          property="taxable_id",
 *          description="Id of taxable relation",
 *          format="int64",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="Taxable Type",
 *          property="taxable_type",
 *          description="Is the taxable relation class type",
 *          format="string",
 *          example="format"
 *      ),
 *      @OA\Property(
 *          title="Stripe ID Tax",
 *          property="stripe_tax_id",
 *          description="Is the strie ID relation with tax assign automatic to subscription",
 *          format="string",
 *          example="format"
 *      )
 * )
 */
class Tax extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'taxes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'value',
        'type',
        'type_user',
        'text_extra',
        'taxable_id',
        'stripe_tax_id'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    
    /**
     * Prepare the taxes model to connect with other models, Polymorphic relationships
     * @return Model taxes
     */
    public function taxable()
    {
        return $this->morphTo();
    }

}
