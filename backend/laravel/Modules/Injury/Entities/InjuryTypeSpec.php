<?php

namespace Modules\Injury\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Generality\Entities\Resource;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class InjuryTypeSpec extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'injury_type_specs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 
        'injury_type_id',
        'image_id'
    ];

    /**
     * The attributes that are not visible.
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
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the image of the type spec.
     */
    public function image()
    {
        return $this->belongsTo(Resource::class);
    }
}
