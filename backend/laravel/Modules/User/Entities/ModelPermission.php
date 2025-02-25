<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

// Models
use Modules\User\Entities\Permission;
use Modules\User\Entities\User;
use Modules\Team\Entities\Team;

class ModelPermission extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'model_has_permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'permission_id',
        'model_type',
        'model_id',
        'entity_type',
        'entity_id',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    // -------- Relationships --------------

    /**
     * Get the entity related to the permission.
     * 
     * @return object
     */
    public function entity()
    {
        return $this->morphTo();
    }

    /**
     * Get the related permission item
     * 
     * @return object
     */
    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    /**
     * Returns a dependant user entity based on the base model sent
     * 
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'model_id')->select(
            'id', 'full_name', 'email', 'active',
        );
    }

    /**
     * Returns a dependant user entity based on the base model sent
     * 
     * @return object
     * */
    public function team()
    {
        return $this->belongsTo(Team::class, 'entity_id')->select(
            'id', 'code', 'name', 'club_id'
        );
    }
}
