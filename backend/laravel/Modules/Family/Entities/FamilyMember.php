<?php

namespace Modules\Family\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// Entities
use Modules\Family\Entities\FamilyMemberType;

class FamilyMember extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'family_members';
    protected $with = ['type'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'mobile_phone',
        'family_member_type_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'phone' => 'array',
        'mobile_phone' => 'array',
    ];

    /**
     * The attributes that are hidden for resulting queries.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'pivot',
    ];

    /**
     * Get the family member type
     */
    public function type()
    {
        return $this->belongsTo(FamilyMemberType::class, 'family_member_type_id');
    }
}
