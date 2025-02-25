<?php

namespace Modules\EffortRecovery\Entities;

use Modules\Player\Entities\Player;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\EffortRecovery\Entities\EffortRecoveryStrategy;
use Modules\EffortRecovery\Entities\WellnessQuestionnaireHistory;

/**
 * @OA\Schema(
 *  title="EffortRecovery",
 *  description="Effort Recovery Program - Programa de Recuperacion del Esfuerzo",
 *  @OA\Xml(name="EffortRecovery"),
 *  @OA\Property(
 *      title="ID",
 *      property="id",
 *      description="Effort recovery item identificator
 *      - Identificador de detalle de programa de recuperacion del esfuerzo",
 *      format="int64",
 *      example="1"
 *  ),
 *  @OA\Property(
 *      title="Player ID",
 *      property="player_id",
 *      description="Player identificator - Identificador de jugador",
 *      format="int64",
 *      example="1"
 *  ),
 *  @OA\Property(
 *      title="Effort Recovery Strategy ID",
 *      property="effort_recovery_strategy_id",
 *      description="Strategy identificator - Identificador de estrategia",
 *      format="int64",
 *      example="1"
 *  ),
 *  @OA\Property(
 *      title="Has Strategy",
 *      property="has_strategy",
 *      description="Strategy usage on the program - Uso de alguna estrategia en el programa",
 *      format="boolean",
 *      example="false"
 *  ),
 * )
 */
class EffortRecovery extends Model
{
    use SoftDeletes;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'effort_recovery';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'player_id',
        'has_strategy',
        'user_id'
    ];

    /**
     * The attributes that must appear as hidden
     *
     * @var array
     */
    protected $hidden = [
        'updated_at',
        'pivot',
    ];

    // ------ Relationships
    /**
     * Returns the related strategy used in the program
     *
     * @return object
     */
    public function strategies()
    {
        return $this->belongsToMany(EffortRecoveryStrategy::class,
            'effort_recovery_programs_strategies'
        );
    }

    /**
     * Returns all the questionnaire history items
     *
     * @return array
     */
    public function questionnaireHistory()
    {
        return $this->hasMany(WellnessQuestionnaireHistory::class)
            ->with('answers')
            ->orderBy('created_at', 'desc')
            ->limit(5);
    }

    /**
     * Return the latest history item
     *
     * @return array
     */
    public function latestQuestionnaireHistory()
    {
        return $this->hasOne(WellnessQuestionnaireHistory::class)
            ->with('answers')
            ->orderBy('created_at', 'desc')
            ->latest();
    }

    /**
     * Return the related player information
     *
     * @return object
     */
    public function player()
    {
        return $this->belongsTo(Player::class)
            ->select('id', 'full_name', 'alias', 'email',
                'team_id', 'image_id', 'weight', 'height',
                'gender_id', 'shirt_number')
            ->with('image')
            ->with('team');
    }
}
