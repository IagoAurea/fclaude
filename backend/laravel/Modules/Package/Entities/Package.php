<?php

namespace Modules\Package\Entities;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Modules\Package\Entities\Subpackage;

class Package extends Model implements TranslatableContract
{
    use Translatable;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'packages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
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
     * Get the subpackages for the package.
     */
    public function subpackages()
    {
        return $this->hasMany(Subpackage::class);
    }

    /**
     * The attributes that belong to the package.
     */
    public function attributes()
    {
        return $this->belongsToMany(
            AttributePack::class, 'attributes_package', 'package_id', 'attribute_id');
    }
    
}
