<?php

namespace Modules\Exercise\Entities;

use Illuminate\Support\Str;
use Modules\User\Entities\User;
use Modules\Sport\Entities\Sport;
use Modules\Team\Entities\Team;
use Illuminate\Database\Eloquent\Model;
use Modules\Generality\Entities\Resource;
use Modules\Classroom\Entities\Classroom;
use Modules\Training\Entities\TargetSession;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Exercise\Entities\ExerciseEntity;
use Modules\Exercise\Entities\ContentExercise;
use Modules\Exercise\Entities\ExerciseContentBlock;
use Modules\Exercise\Entities\DistributionExercise;
use Modules\Exercise\Entities\ExerciseEducationLevel;
use Modules\Training\Entities\SubjecPerceptEffort;

class Exercise extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'exercises';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'code',
        'description',
        'favorite',
        'dimentions',
        'duration',
        'repetitions',
        'duration_repetitions',
        'break_repetitions',
        'exercise_education_level_id',
        'series',
        'break_series',
        'difficulty',
        'intensity',
        'distribution_exercise_id',
        'user_id',
        'entity_type',
        'entity_id',
        'resource_id',
        '3d',
        'thumbnail',
        'sport_id',
        'image_id'
    ];

    /**
     * The attributes that must not be showable by querying.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
        'updated_at',
    ];

    /**
     * Register any events.
     *
     * @return void
     */
    public static function boot() {
        parent::boot();

        static::creating(function($model) {
            $model->code = Str::uuid()->toString();
        });
    }

    /**
     * The relationships to be inlcuded
     *
     * @var array
     */
    protected $with = [
        'image'
    ];

    /**
     * Get the exercise that owns the resource.
     *
     * @return Resource
     */
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
    
    /**
     * Get the exercise that owns the image.
     *
     * @return Resource
     */
    public function image()
    {
        return $this->belongsTo(Resource::class);
    }

    /**
     * Get the exercise that owns the distribution exercise.
     *
     * @return DistributionExercise
     */
    public function distribution()
    {
        return $this->hasOne(DistributionExercise::class, 'id', 'distribution_exercise_id');
    }

    /**
     * Retrieves the related entity (team - classroom) to the exercise
     *
     * @return ExerciseEntity[]
     */
    public function exerciseEntities()
    {
        return $this->belongsToMany(ExerciseEntity::class, 'exercise_entities', 'exercise_id', 'entity_id');
    }

    /**
     * Retrieve related entity get
     */
    public function entity()
    {
        return $this->belongsTo(ExerciseEntity::class, 'id', 'exercise_id');
    }

    /**
     * Get the exercise that owns the content exercise.
     *
     * @return ContentExercise
     */
    public function content()
    {
        return $this->hasOne(ContentExercise::class, 'id', 'content_exercise_id');
    }

    /**
     * Retieve the multilpe contents related to the exercise
     *
     * @return ContentExercise[]
     */
    public function contents()
    {
        return $this->belongsToMany(ContentExercise::class, 'exercises_contents_relations');
    }

    /**
     * Retrieves the related sport to the exercise
     *
     * @return Sport
     */
    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }
    
    /**
     * Retrieves the related sport to the exercise
     *
     * @return Sport
     */
    public function intensityRelation()
    {
        return $this->belongsTo(SubjecPerceptEffort::class, 'intensity', 'id');
    }
    
    /**
     * Retrieves the related user to the exercise
     *
     * @return User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Retrieves the related block contents to the exercise (professor profile relation)
     *
     * @return ExerciseContentBlock[]
     */
    public function contentBlocks()
    {
        return $this->belongsToMany(ExerciseContentBlock::class, 'exercise_content_block_relations');
    }

    /**
     * Retrieves a singele ducation item related to the exercise (professor profile relation)
     *
     * @return ExerciseEducationLevel
     */
    public function exerciseEducationLevel()
    {
        return $this->belongsTo(ExerciseEducationLevel::class);
    }

    /**
     * Retrieves the related block contents to the exercise (professor profile relation)
     *
     * @return TargetSession[]
     */
    public function targets()
    {
        return $this->belongsToMany(TargetSession::class, 'exercise_target_sessions');
    }

    /**
     * Retrieves the related teams to the exercise
     *
     * @return Team[]
     */
    public function teams()
    {
        return $this->morphedByMany(Team::class, 'entity', 'exercise_entities');
    }

    /**
     * Retrieves the related teams to the exercise
     *
     * @return Team[]
     */
    public function classrooms()
    {
        return $this->morphedByMany(Classroom::class, 'entity', 'exercise_entities');
    }



}
