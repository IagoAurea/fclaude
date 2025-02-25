<?php

namespace Modules\Sport\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class SportPositionSpec extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sports_positions_specs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'sport_position_id'
    ];

    /**
     * The attributes that are not visible for queries
     * 
     * @var array
     */
    protected $hidden = [
        'translations'
    ];

    /**
     * The attributes that are mass assignable translation.
     *
     * @var array
     */
    public $translatedAttributes = [
        'name'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
