<?php

namespace Modules\Training\Entities;

use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Training\Entities\ExerciseSession;


/**
 * @OA\Schema(
 *      title="ExerciseSessionLike",
 *      description="ExerciseSessionLike model",
 *      @OA\Xml( name="ExerciseSessionLike"),
 *      @OA\Property( title="User", property="user_id", description="user associate", format="integer", example="1" ),
 *      @OA\Property( title="Exercise Session", property="exercise_session_id", description="Exercise Session Associate", format="integer", example="1" ),     
 * * )
 */
class ExerciseSessionLike extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'exercise_session_likes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
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
     * Returns the Exercise session object related to the  Exercise Session Detail
     * 
     * @return Array
     */
    public function exercise_session () 
    {
        return $this->belongsTo(ExerciseSession::class);
    }

     /**
     * Returns the user  of the like
     */
    public function user () 
    {
        return $this->belongsTo(
            User::class, 'user_id'
        )->select(
            'id', 'full_name', 'email', 'username'
        );
    }

}
