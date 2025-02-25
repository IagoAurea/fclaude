<?php

namespace Modules\Test\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      title="ConfigurationTranslation",
 *      description="ConfigurationTranslation model",
 *      @OA\Xml( name="ConfigurationTranslation"),
 *      @OA\Property( title="Locale", property="locale", description="translation language", format="string", example="en" ),
 *      @OA\Property( title="Configuration", property="configuration_id", description="entity id", format="integer", example="1" ),
 *      @OA\Property( title="Name", property="name", description="translated name", format="string", example="average" ),
 *      @OA\Property( title="Description", property="description", description="translated description", format="string", example="is the average to result" )
 * )
 */
class ConfigurationTranslation extends Model
{
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'configuration_translations';

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
