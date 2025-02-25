<?php

namespace Modules\Club\Entities;

use Modules\Team\Entities\TeamStaff;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Modules\Team\Entities\WorkingExperiencesStaff;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

/**
 * @OA\Schema(
 *      title="PositionStaff",
 *      description="PositionStaff model",
 *      @OA\Xml( name="PositionStaff"),
 *      @OA\Property( title="Code", property="code", description="code to identify", format="string", example="new" ),
 * * )
 */
class PositionStaff extends Model implements TranslatableContract
{
    use Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'position_staff';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'jobs_area_id',
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
     * Returns list working experiences objects related to the position
     * 
     * @return Array
     */
    public function working_experiences () 
    {
        return $this->hasMany(WorkingExperiencesStaff::class);
    }

    /**
     * Returns list team staff objects related to the position
     * 
     * @return Array
     */
    public function team_staffs () 
    {
        return $this->hasMany(TeamStaff::class);
    }
}
