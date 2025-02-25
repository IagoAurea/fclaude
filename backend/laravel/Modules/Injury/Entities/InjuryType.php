<?php

namespace Modules\Injury\Entities;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Modules\Injury\Entities\InjuryTypeSpec;

class InjuryType extends Model implements TranslatableContract
{
    use Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'injury_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code'
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
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Related type spec to the injury type
     * 
     * @return array
     */
    public function specs()
    {
        return $this->hasMany(InjuryTypeSpec::class);
    }
}
