<?php

namespace Modules\AlumnControl\Entities;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Modules\Generality\Entities\Resource;

class DailyControlItem extends Model implements TranslatableContract
{
    use Translatable;

   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'daily_control_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'image_id',
    ];

    /**
     * The attributes that must not be shown.
     *
     * @var array
     */
    protected $hidden = [
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
     * Get the image of the player.
     */
    public function image()
    {
        return $this->belongsTo(Resource::class)->select(
            'id', 'url', 'mime_type', 'size'
        );
    }
}
