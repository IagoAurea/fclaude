<?php

namespace Modules\Club\Entities;

use Module\User\Entities\User;
use Module\Club\Entities\ClubUserType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClubUser extends Model
{
    use SoftDeletes;

    /**
     * Disabled timestamps for not inserting data
     * 
     * @var String
     */
    public $timestamps = false;

    /**
     * Name of the table
     * 
     * @var String 
     */
    protected $table = 'club_users';

    /**
     * List of all fillable properties
     *
     * @var Array
     */
    protected $fillable = [
        'user_id',
        'club_id',
        'club_user_type_id'
    ];

    // -- Relationships
    
    /**
     * Get the user
     */
    public function user ()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the user type depending on the club
     */
    public function user_type()
    {
        return $this->belongsTo(ClubUserType::class);
    }
}
