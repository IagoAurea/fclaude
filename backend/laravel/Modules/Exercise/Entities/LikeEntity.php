<?php

namespace Modules\Exercise\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LikeEntity extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'like_entities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entity_type',
        'entity_id',
        'user_id',
    ];

}
