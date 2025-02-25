<?php

namespace Modules\Test\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      title="TableDetailTranslation",
 *      description="TableDetailTranslation model",
 *      @OA\Xml( name="TableDetailTranslation"),
 *      @OA\Property( title="Locale", property="locale", description="translation language", format="string", example="en" ),
 *      @OA\Property( title="Table Detail", property="table_detail_id", description="entity id", format="integer", example="1" ),
 *      @OA\Property( title="Name", property="name", description="translated name", format="string", example="Table" ),
 *      @OA\Property( title="Description", property="description", description="translated description", format="string", example="is a table" )
 * )
 */
class TableDetailTranslation extends Model
{
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'table_detail_translations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

}
