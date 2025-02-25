<?php

namespace Modules\Family\Entities;

use Illuminate\Database\Eloquent\Model;

// External Models
use Modules\Address\Entities\Address;

class Family extends Model
{
    const MS_SINGLE = 0;
    const MS_MARRIED = 1;
    const MS_DIVORCED = 2;

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
    protected $table = 'families';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parents_marital_status_id',
        'entity_type',
        'entity_id',
    ];

    /**
     * The attributes that must not be retrieved from querying.
     *
     * @var array
     */
    protected $hidden = [
        'entity_type',
        'entity_id',
    ];

    /**
     * The attributes that are calculated types.
     *
     * @var array
     */
    protected $appends = [
        'parents_marital_status',
    ];

    /**
     * Get gender types
     * @return array
     */
    public static function getMaritalStatusTypes()
    {
        return [
            [
                "id" => self::MS_SINGLE,
                "code" => 'single',
            ],
            [
                "id" => self::MS_MARRIED,
                "code" => 'married',
            ],
            [
                "id" => self::MS_DIVORCED,
                "code" => 'divorced',
            ],
        ];
    }

    /**
     * Get the marital status attribute
     */
    public function getParentsMaritalStatusAttribute()
    {
        $statuses = static::getMaritalStatusTypes();
        $key = array_search($this->parents_marital_status_id, array_column($statuses, 'id'));

        return $statuses[$key];
    }

    // --------- Relationships
    /**
     * Get all of the models that own activities.
     * 
     * @return object
     */
    public function entity() {
        return $this->morphTo();
    }

    /**
     * Get all the members related to the family
     * 
     * @return array
     */
    public function members()
    {
        return $this->belongsToMany(FamilyMember::class, 'family_entity_members');
    }

    /**
     * Get the related addess to the family entity
     * 
     * @return object
     */
    public function address()
    {
        return $this->morphOne(Address::class, 'entity');
    }
}
