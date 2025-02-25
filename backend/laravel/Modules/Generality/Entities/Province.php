<?php

namespace Modules\Generality\Entities;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Province extends Model implements TranslatableContract
{
    use Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'provinces';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'iso2',
        'country_id'
    ];

    /**
     * Attributes that must not be returned
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
     * Connect the province with taxes, Polymorphic relationships
     * @return Connection to taxes
     */
    public function taxes(){
        return $this->morphMany(Tax::class, 'taxable');
    }

}
