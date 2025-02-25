<?php

namespace Modules\Package\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Package\Entities\Subpackage;

class PackagePrice extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'packages_price';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'min_licenses',
        'max_licenses',
        'month',
        'year',
        'subpackage_id',
        'stripe_month_id',
        'stripe_year_id',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    
    /**
     * The subpackage that belong to the package price.
     */
    public function subpackage()
    {
        return $this->belongsTo(Subpackage::class)->with(
            'package', 'attributes'
        );
    }
}
