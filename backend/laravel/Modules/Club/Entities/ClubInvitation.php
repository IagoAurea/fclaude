<?php

namespace Modules\Club\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

// External models
use Modules\User\Entities\User;
use Modules\Club\Entities\Club;
use Modules\Team\Entities\Team;


/**
 * @OA\Schema(
 *  title="ClubInvitation",
 *  description="ClubInvitation model",
 *  @OA\Xml( name="ClubInvitation"),
 *  @OA\Property( title="Club", property="club_id", description="club associate", format="integer", example="1" ),
 *  @OA\Property( title="Team", property="team_id", description="team associate", format="integer", example="1" ),
 *  @OA\Property( title="Inviter", property="inviter_user_id", description="user inviter", format="integer", example="1" ),
 *  @OA\Property( title="Invited", property="invited_user_id", description="user invited", format="integer", example="2" ),
 *  @OA\Property( title="Invited Email", property="invited_user_email", description="email user invited", format="email", example="email@email.com" ),
 *  @OA\Property( title="Code", property="code", description="code to identify", format="string", example="code" ),
 *  @OA\Property( title="Accepted Date", property="accepted_at", description="Date to accepted", format="date", example="2021-11-10" ),
 *  @OA\Property( title="Expires Date", property="expires_at", description="Date to expires", format="date", example="2022-11-10" )
 * )
 */
class ClubInvitation extends Model
{
    use SoftDeletes;

    const STATUS_REJECTED = 'rejected';
    const STATUS_ACTIVE = 'active';

    /**
     * Name of the table
     *
     * @var String
     */
    protected $table = 'club_invitations';

    /**
     * List of all fillable properties
     *
     * @var Array
     */
    protected $fillable = [
        'club_id',
        'team_id',
        'inviter_user_id',
        'invited_user_id',
        'invited_user_email',
        'code',
        'status',
        'accepted_at',
        'expires_at',
    ];

    /**
     * List of all hidden properties
     *
     * @var Array
     */
    protected $hidden = [
        'updated_at',
        'expires_at',
        'deleted_at',
        'inviter_user_id',
        'invited_user_id',
        'club_id'
    ];

    /**
     * List of all date transformable properties
     *
     * @var Array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'expires_at',
        'deleted_at',
    ];

    /**
     * Register any events.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        
        self::creating(function($model) {
            if (!$model->code) {
                $model->code = Str::uuid()->toString();
            }
        });
    }
    
    /**
     * Returns the user that makes the invitation
     *
     * @return Object
     */
    public function inviter_user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns the user that receives the invitation
     *
     * @return Object
     */
    public function invited_user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns the related club object
     *
     * @return Object
     */
    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    /**
     * Returns the related club object
     *
     * @return Object
     */
    public function team()
    {
        return $this->belongsTo(Team::class)->select('id', 'name', 'image_id')->with('image');
    }
}
