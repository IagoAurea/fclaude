<?php

namespace Modules\Subscription\Entities;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;
use Modules\Subscription\Entities\License;
use Modules\Package\Entities\PackagePrice;
use Laravel\Cashier\Subscription as CashierSubscription;

/**
 * @OA\Schema(
 *  title="Subscription",
 *  description="Effort Recovery Program - Programa de Recuperacion del Esfuerzo",
 *  @OA\Xml(name="Subscription"),
 *  @OA\Property(
 *      title="ID",
 *      property="id",
 *      description="Subscription identificator - Identificador de suscripcion",
 *      format="int64",
 *      example="1"
 *  ),
 *  @OA\Property(
 *      title="User ID",
 *      property="user_id",
 *      description="User identificator - Identificador de usuario",
 *      format="int64",
 *      example="1"
 *  ),
 *  @OA\Property(
 *      title="Name",
 *      property="name",
 *      description="Subscription name - Nombre de subscripcion",
 *      format="string",
 *      example="Example name"
 *  ),
 *  @OA\Property(
 *      title="Stripe ID",
 *      property="stripe_id",
 *      description="Stripe identificator - Identificador de stripe",
 *      format="string",
 *      example="abcdez"
 *  ),
 *  @OA\Property(
 *      title="Stripe Status",
 *      property="stripe_status",
 *      description="Stripe status - Status de stripe",
 *      format="string",
 *      example="abcdez"
 *  ),
 *  @OA\Property(
 *      title="Stripe Plan",
 *      property="stripe_plan",
 *      description="Stripe plan - Plan de stripe",
 *      format="string",
 *      example="abcdez"
 *  ),
 *  @OA\Property(
 *      title="Quantity",
 *      property="quantity",
 *      description="License quantity - Cantidad de licencias",
 *      format="int64",
 *      example="1"
 *  ),
 *  @OA\Property(
 *      title="Interval",
 *      property="interval",
 *      description="Interval of charging - Intervalo de cobro",
 *      format="string",
 *      example="month"
 *  ),
 *  @OA\Property(
 *      title="Trial End Date",
 *      property="trial_ends_at",
 *      description="Date of the trial end - Fecha de fin del periodo de prueba",
 *      type="string",
 *      format="date-time",
 *      example="2021-01-01 00:00:00"
 *  ),
 *  @OA\Property(
 *      title="End Date",
 *      property="ends_at",
 *      description="Date of the subscription end - Fecha de fin de la suscripcion",
 *      type="string",
 *      format="date-time",
 *      example="2021-01-01 00:00:00"
 *  ),
 * )
 */

class Subscription extends CashierSubscription
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'subscriptions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quantity',
        'user_id',
        'stripe_id',
        'stripe_status',
        'stripe_plan',
        'name',
        'trial_ends_at',
        'ends_at',
        'interval',
        'amount',
        'package_price_id',
        'current_period_start_at',
        'current_period_end_at'
    ];

    /**
     * The attributes that must be hidden from querying
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Calculated variables related to the entity
     *
     * @var array
     */
    protected $appends = [
        'package_price_name',
        'subpackage_name',
        'package_name',
        'package_code',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'trial_ends_at' => 'datetime',
        'current_period_start_at' => 'datetime',
        'current_period_end_at' => 'datetime',
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
            $model->trial_ends_at = Carbon::now()->addDay(config('api.trial_days'));
        });
    }

    /**
     * Get the package price name from relation
     *
     * @return string
     */
    public function getPackagePriceNameAttribute()
    {
        return $this->packagePrice->name;
    }

    /**
     * Get the subpackage name column from relation
     *
     * @return string
     */
    public function getSubpackageNameAttribute()
    {
        return $this->packagePrice->subpackage->name;
    }

    /**
     * Get the final package name column from relation
     *
     * @return string
     */
    public function getPackageNameAttribute()
    {
        return $this->packagePrice->subpackage->package->name;
    }

    /**
     * Get the final package code column from relation
     *
     * @return string
     */
    public function getPackageCodeAttribute()
    {
        return $this->packagePrice->subpackage->package->code;
    }

    /**
     * The license that belongs to the subscription.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns the related licenses
     *
     * @return object
     */
    public function licenses()
    {
        return $this->hasMany(License::class);
    }

    /**
     * The package price that belongs to the subscription.
     */
    public function packagePrice()
    {
        return $this->belongsTo(PackagePrice::class)
            ->select(['id', 'name', 'subpackage_id', 'min_licenses', 'max_licenses'])
            ->with('subpackage');
    }
}
