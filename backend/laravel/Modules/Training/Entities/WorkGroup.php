<?php

namespace Modules\Training\Entities;

use Illuminate\Support\Str;
use Modules\Player\Entities\Player;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Alumn\Entities\Alumn;
use Modules\Training\Entities\ExerciseSessionExercise;

/**
 * @OA\Schema(
 *      title="WorkGroup",
 *      description="WorkGroup model",
 *      @OA\Xml( name="WorkGroup"),
 *      @OA\Property( title="Name", property="name", description="group name", format="string", example="group" ),
 *      @OA\Property( title="Description", property="description", description="group description", format="string", example="new group" ),
 *      @OA\Property( title="Color", property="color", description="color", format="string", example="AAAAAAA" ),
 *      @OA\Property( title="Exercise session", property="exercise_session_id", description="exercise session asocciate", format="integer", example="1" )
 * * )
 */
class WorkGroup extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'work_groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'description',
        'color',
        'exercise_session_id'
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
        'pivot'
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
     * Register any events.
     *
     * @return void
     */
    public static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $model->code = Str::uuid()->toString();
        });
    }

     /**
     * Returns a list of work groups objects related to the  Exercise Session Detail
     *
     * @return Array
     */
    public function  exercise_session_exercise()
    {
        return $this->belongsToMany(ExerciseSessionExercise::class, 'exercise_session_exercise_work_group')
            ->withTimestamps();
    }

    /**
     * Get all of the players that are assigned this work group.
     */
    public function players()
    {
        return $this->morphedByMany(Player::class, 'applicant', 'work_group_applicants',);
    }

    /**
     * Get all of the alumns that are assigned this work group.
     */
    public function alumns()
    {
        return $this->morphedByMany(Alumn::class, 'applicant', 'work_group_applicants',);
    }
}
