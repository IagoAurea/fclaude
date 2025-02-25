<?php

namespace Modules\Scouting\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Modules\Scouting\Database\Factories\ActionFactory;
use Astrotomic\Translatable\Translatable;
use Modules\Generality\Entities\Resource;
use Illuminate\Database\Eloquent\Model;

class Action extends Model implements TranslatableContract
{
    use Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'actions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'order',
        'image_id',
        'rival_team_action',
        'side_effect',
        'sport_id',
        'is_total',
        'calcultate_total',
        'show',
        'show_player',
        'custom_params'
    ];

    /**
     * The relationships to be inlcuded
     *
     * @var array
     */
    protected $with = [
        'image'
    ];

    /**
     * The attributes that are mass assignable translation.
     *
     * @var array
     */
    public $translatedAttributes = [
        'name',
        'plural'
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
     * Returns the related image resource object
     * 
     * @return Object
     */
    public function image()
    {
        return $this->belongsTo(Resource::class);
    }
}
