<?php

namespace Modules\Test\Entities;

use Illuminate\Support\Str;
use Modules\Test\Entities\Table;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Modules\Test\Entities\TableDetailValue;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

/**
 * @OA\Schema(
 *      title="TableDetail",
 *      description="TableDetail model",
 *      @OA\Xml( name="TableDetail"),
 *      @OA\Property( title="Table", property="table_id", description="table to which it belongs", format="integer", example="1" ),
 * )
 */
class TableDetail extends Model
{
   // use SoftDeletes;
    use Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'table_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'table_id',
        'is_index',
        'code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'translations'
    ];

    /**
     * The attributes that should be cast to datetime types.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
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
     * Returns the category object related to the  Question
     * 
     * @return Array
     */
    public function table () 
    {
        return $this->belongsTo(Table::class);
    }

    /**
     * Returns the category object related to the  Question
     * 
     * @return Array
     */
    public function table_detail_values () 
    {
        return $this->HasMany(TableDetailValue::class);
    }



}
