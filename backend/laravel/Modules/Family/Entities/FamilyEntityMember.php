<?php

namespace Modules\Family\Entities;

use Illuminate\Database\Eloquent\Model;

class FamilyEntityMember extends Model
{
    /**
     * Disabled timestamps for not inserting data
     * 
     * @var Boolean
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'family_entity_members';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'family_id',
        'family_member_id',
    ];
}
