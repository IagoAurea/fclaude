<?php

namespace Modules\Package\Entities;

use Modules\Sport\Entities\Sport;
use Modules\Package\Entities\Package;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Modules\Package\Entities\PackagePrice;
use Modules\Package\Entities\AttributePack;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Generality\Entities\Resource;

class Subpackage extends Model implements TranslatableContract
{
    use Translatable, SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'subpackages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'package_id',
        'custom',
        'status',
        'image_id'
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
        'name',
        'description'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that belong to the subpackage.
     */
    public function attributes()
    {
        return $this->belongsToMany(
            AttributePack::class,
            'attributes_subpackage',
            'subpackage_id',
            'attribute_id'
        )->withPivot('quantity', 'available');
    }

    /**
     * The prices that belong to the subpackage.
     */
    public function prices()
    {
        return $this->hasMany(PackagePrice::class);
    }

    /**
     * The sports that belong to the subpackage.
     */
    public function sports()
    {
        return $this->belongsToMany(Sport::class, 'subpackage_sports');
    }

    /**
     * Related package item
     */
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function image()
    {

        return $this->belongsTo(Resource::class, 'image_id');
    }
}
