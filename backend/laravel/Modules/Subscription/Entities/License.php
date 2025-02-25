<?php

namespace Modules\Subscription\Entities;

use Illuminate\Support\Str;
use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Entities\Activity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Subscription\Entities\Subscription;

/**
 * @OA\Schema(
 *  title="License",
 *  description="License - Licencia de Subscripcion",
 *  @OA\Xml(name="License"),
 *  @OA\Property(
 *      title="ID",
 *      property="id",
 *      description="License identificator - Identificador de licencia ",
 *      format="int64",
 *      example="1"
 *  ),
 *  @OA\Property(
 *      title="Subscription ID",
 *      property="subscription_id",
 *      description="Subscription identificator - Identificador de subscripcion",
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
 *      title="Code",
 *      property="code",
 *      description="License code - Codigo interno de licencia",
 *      format="string",
 *      example="a0b1-c2d3-e4c5-f6h7"
 *  ),
 *  @OA\Property(
 *      title="Status",
 *      property="status",
 *      description="License code - Codigo interno de licencia",
 *      format="string",
 *      example="available"
 *  ),
 *  @OA\Property(
 *      title="Accepted at",
 *      property="accepted_at",
 *      description="License accepted date - Fecha de aceptado de licencia",
 *      type="string",
 *      format="date-time",
 *      example="2021-01-01 00:00:00"
 *  ),
 *  @OA\Property(
 *      title="Expires at",
 *      property="expires_at",
 *      description="License expiring_date - Fecha de expiracion de invitacionde licencia",
 *      type="string",
 *      format="date-time",
 *      example="2021-01-01 00:00:00"
 *  ),
 * )
 */
class License extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'licenses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'status',
        'subscription_id',
        'user_id',
        'accepted_at',
        'expires_at',
        'token',
    ];

    /**
     * The attributes that must be hidden from querying
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
    ];

    /**
     * Register any events.
     *
     * @return void
     */
    public static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $model->code = Str::uuid()->toString();
            $model->token = Str::random(60);
        });
    }

    /**
     * Returns the related user to the license item
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'email', 'active', 'full_name');
    }

    /**
     * Returns the related subscription to the license item
     *
     * @return object
     */
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    /**
     * Return a list of related activities
     *
     * @return Array
     */
    public function activities()
    {
        return $this->morphMany(Activity::class, 'entity')
            ->with('activity_type', 'user', 'entity', 'secondaryEntity')
            ->orderBy('date', 'desc');
    }
}
