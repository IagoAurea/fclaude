<?php

namespace Modules\Competition\Entities;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Modules\Sport\Entities\Sport;

class TypeModalityMatch extends Model
{
    use Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'type_modalities_match';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
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
     * List of hidden properties of the model
     * 
     * @var Array
     */
    protected $hidden = [
        'translations'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Relation with sport
     * @return hasMany
     */
    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }
}
