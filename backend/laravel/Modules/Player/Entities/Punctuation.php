<?php

namespace Modules\Player\Entities;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

/**
 * @OA\Schema(
 *      title="Punctuation",
 *      description="Punctuation model",
 *      @OA\Xml( name="Punctuation"),
 *      @OA\Property( title="Code", property="code", description="code to identify", format="string", example="physical_abilities" ),
 *      @OA\Property( title="Value", property="value", description="value", format="double", example="5.5" ),
 *      @OA\Property( title="Color", property="color", description="color", format="string", example="#FFFF" ),
 *      @OA\Property( title="Maximun", property="max", description="maximun", format="interger", example="7" ),
 *      @OA\Property( title="Minimun", property="min", description="minimun", format="integer", example="5" ),
 * )
 */
class Punctuation extends Model
{
    use Translatable;

    /**
      * The table associated with the model.
      *
      * @var string
      */
     protected $table = 'punctuations';
 
     /**
      * The attributes that are mass assignable.
      *
      * @var array
      */
     protected $fillable = [
         'code',
         'value',
         'color',
         'max',
         'min'
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
}
