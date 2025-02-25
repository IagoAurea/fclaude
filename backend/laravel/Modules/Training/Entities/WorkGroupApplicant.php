<?php

namespace Modules\Training\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      title="WorkGroupApplicant",
 *      description="WorkGroupApplicant model",
 *      @OA\Xml( name="WorkGroupApplicant"),
 *      @OA\Property( title="Applicant_id", property="applicant_id", description="player or alumn associate", format="integer", example="1" ),
 *      @OA\Property( title="Work Group", property="work_group_id", description="group associate", format="integer", example="1" ),     
 *  )
 */
class WorkGroupApplicant extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'work_group_applicants';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'work_group_id',
        'applicant_id',
        'applicant_type',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

     /**
     * Get all of the models.
     *
     * @return array
     */
    public function applicant()
    {
        return $this->morphTo();
    }
}
