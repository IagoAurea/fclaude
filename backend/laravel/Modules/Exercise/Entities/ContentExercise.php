<?php

namespace Modules\Exercise\Entities;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Modules\Generality\Entities\Resource;
use Modules\Training\Entities\TargetSession;
use Modules\Training\Entities\SubContentSession;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class ContentExercise extends Model implements TranslatableContract
{
    use Translatable;

   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contents_exercise';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'image_id'
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
     * Allways show this relationships
     *
     * @var array
     */
    protected $with = [
        'image'
    ];

    /**
     * Items that must not be showable from querying
     * @var array
     */
    protected $hidden = [
        'translations',
        'pivot',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

     /**
     * Get the team that owns the image.
     */
    public function image()
    {
        return $this->belongsTo(Resource::class);
    }

    /**
     * Returns the Exercise Session Effort Assessment object related to the Effort Assessment Gps
     *
     * @return Array
     */
    public function sub_contents()
    {
        return $this->hasMany(SubContentSession::class);
    }
    
    /**
     * Returns the Exercise Session Effort Assessment object related to the Effort Assessment Gps
     *
     * @return Array
     */
    public function targets()
    {
        return $this->hasMany(TargetSession::class);
    }
}
