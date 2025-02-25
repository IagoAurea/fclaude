<?php

namespace Modules\Competition\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Sport\Entities\Sport;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;


class TypeCompetition extends Model
{
    use Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'type_competitions';

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
     * @return BelongsToMany
     */
    public function sport()
    {
        return $this->belongsToMany(Sport::class, 'type_competition_sports');
    }

}
