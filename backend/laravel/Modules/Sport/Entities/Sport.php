<?php

namespace Modules\Sport\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Generality\Entities\Resource;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Sport extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    /**
     * Sport codes
     */
    const FOOTBALL = 'football';
    const BASKETBALL = 'basketball';
    const HANDBALL = 'handball';
    const INDOOR_SOCCER = 'indoor_soccer';
    const VOLLEYBALL = 'volleyball';
    const BEACH_VOLLEYBALL = 'beach_volleyball';
    const BADMINTON = 'badminton';
    const TENNIS = 'tennis';
    const PADEL = 'padel';
    const ROLLER_HOCKEY = 'roller_hockey';
    const FIELD_HOCKEY = 'field_hockey';
    const ICE_HOCKEY = 'ice_hockey';
    const RUGBY = 'rugby';
    const BASEBALL = 'baseball';
    const CRICKET = 'cricket';
    const SWIMMING = 'swimming';
    const WATERPOLO = 'waterpolo';
    const AMERICAN_SOCCER = 'american_soccer';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sports';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'model_url',
        'profile_type',
        'time_game',
        'image_id',
        'image_exercise_id',
        'court_id',
        'is_teacher_profile'
    ];

     /**
     * The relationships to be inlcuded
     *
     * @var array
     */
    protected $with = [
        'image',
        'imageExercise',
        'court'
    ];

    /**
     * The attributes that must be hidden for eloquent querying.
     *
     * @var array
     */
    protected $hidden = [
        'pivot',
        'translations',
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

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'code';
    }

    /**
     * Get the sport court image.
     */
    public function image()
    {
        return $this->belongsTo(Resource::class);
    }
    
    /**
     * Get the sport court image.
     */
    public function imageExercise()
    {
        return $this->belongsTo(Resource::class);
    }

    /**
     * Get the sport court image.
     */
    public function court()
    {
        return $this->belongsTo(Resource::class);
    }

}
