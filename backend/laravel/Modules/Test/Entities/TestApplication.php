<?php

namespace Modules\Test\Entities;

use Illuminate\Support\Str;
use Modules\Test\Entities\Test;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Staff\Entities\StaffUser;
use Modules\Team\Entities\TeamStaff;
use Modules\Test\Entities\TestApplicationAnswer;

/**
 * @OA\Schema(
 *      title="TestApplication",
 *      description="TestApplication model",
 *      @OA\Xml( name="TestApplication"),
 *      @OA\Property( title="Test", property="test_id", description="code to identify the test applied", format="integer", example="1" ),
 *      @OA\Property( title="Applicable Type", property="applicable_type", description="type of entity to which the test was applied", format="string", example="Modules\Injury\Entities\PhaseDetail" ),
 *      @OA\Property( title="Applicable Id", property="applicable_id", description="id of the related entity", format="integer", example="34" ),
 *      @OA\Property( title="Result", property="result", description="percentage or points reached", format="double", example="100" ),
 * )
 */
class TestApplication extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'test_applications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'test_id',
        'date_application',
        'applicant_type',
        'applicant_id',
        'professional_directs_id',
        'applicable_type',
        'applicable_id',
        'result',
        'average',
        'median',
        'chart_order',
        'score',
        'user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
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
     * The attributes that should be cast to datetime types.
     *
     * @var array
     */
    protected $with = [
        'professional_direct'
    ];

    /**
     * Register any events.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($model->code == "") {
                $model->code = Str::uuid()->toString();
            }
        });
    }

    /**
     * Returns the category object related to the  Question
     *
     * @return Array
     */
    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    /**
     * Returns the category object related to the Staff member
     *
     * @return Array
     */
    public function professional_direct()
    {
        return $this->belongsTo(StaffUser::class, 'professional_directs_id', 'id');
    }

    /**
     * Get the parent applicant model (player or alumn).
     */
    public function applicant()
    {
        return $this->morphTo();
    }

    /**
     * Get the parent applicable model (rfd or other).
     */
    public function applicable()
    {
        return $this->morphTo();
    }

    /**
     * Returns the category object related to the  Question
     *
     * @return Array
     */
    public function answers()
    {
        return $this->hasMany(TestApplicationAnswer::class);
    }
}
