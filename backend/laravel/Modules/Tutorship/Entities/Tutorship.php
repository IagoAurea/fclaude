<?php

namespace Modules\Tutorship\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Alumn\Entities\Alumn;
use Modules\Classroom\Entities\Teacher;
use Modules\Club\Entities\Club;

/**
 * @OA\Schema(
 *      title="Tutorship",
 *      description="The tutorship of a school center",
 *      @OA\Xml( name="Tutorship"),
 *      @OA\Property(
 *          title="Date",
 *          property="date",
 *          description="Date of the tutorship",
 *          format="date",
 *          example="2022-02-20"
 *      ),
 *      @OA\Property(
 *          title="Tutor",
 *          property="teacher_id",
 *          description="Identifier representing the teacher who will be the tutor",
 *          format="string",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="Tutorship type",
 *          property="tutorship_type_id",
 *          description="Identifier representing the tutorship type who will be the tutor",
 *          format="string",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="School Center",
 *          property="club_id",
 *          description="Identifier of the school center it belongs to",
 *          format="string",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="Specialist referral",
 *          property="specialist_referral_id",
 *          description="Identifier representing the specialist referral",
 *          format="string",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="Alumn",
 *          property="alumn_id",
 *          description="Identifier representing the alumn",
 *          format="string",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="Reason",
 *          property="reason",
 *          description="String representing the reason of the tutorship",
 *          format="string",
 *          example="string"
 *      ),
 *      @OA\Property(
 *          title="Resume",
 *          property="resume",
 *          description="String representing a resume of the tutorship",
 *          format="string",
 *          example="string"
 *      ),
 * )
 */
class Tutorship extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'teacher_id',
        'club_id',
        'tutorship_type_id',
        'specialist_referral_id',
        'alumn_id',
        'reason',
        'resume',
        'user_id'
    ];

    protected $with = [
        'tutor',
        'scholarCenter',
        'tutorshipType',
        'specialistReferral',
        'alumn'
    ];

    /**
     * Relation with the scholar center
     *
     * @return BelongsTo
     */
    public function scholarCenter()
    {
        return $this->belongsTo(Club::class, 'club_id');
    }

    /**
     * Relation with the tutor
     *
     * @return BelongsTo
     */
    public function tutor()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    /**
     * Relation with the tutorship type
     *
     * @return BelongsTo
     */
    public function specialistReferral()
    {
        return $this->belongsTo(SpecialistReferral::class);
    }

    /**
     * Relation with the tutorship type
     *
     * @return BelongsTo
     */
    public function tutorshipType()
    {
        return $this->belongsTo(TutorshipType::class);
    }

    /**
     * Relation with the tutor
     *
     * @return BelongsTo
     */
    public function alumn()
    {
        return $this->belongsTo(Alumn::class);
    }
}
