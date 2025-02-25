<?php

namespace Modules\Health\Entities;

use Illuminate\Database\Eloquent\Model;

class Health extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'health_relations';

    /**
     * Table primary key name type.
     * 
     * @var int
     */
    protected $primaryKey = null;

    /**
     * Table incrementing id behavior.
     * 
     * @var boolean
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entity_id',
        'entity_type',
        'health_entity_id',
        'health_entity_type',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get all of the models that own any health entity
     * 
     * @return Array|Object
     */
    public function entity() {
        return $this->morphTo();
    }
    
    /**
     * Get all of health-reated entities
     * 
     * @return Array|Object
     */
    public function healthEntity() {
        return $this->morphTo();
    }
}
